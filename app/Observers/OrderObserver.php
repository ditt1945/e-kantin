<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use App\Notifications\PreorderNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        // Update menu statistics when order is created
        $this->updateMenuStats($order);

        // Notify tenant for preorder
        if ($order->isPreorder()) {
            $this->notifyTenantForPreorder($order);
        }
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        // If order status changes to completed, update menu stats
        if ($order->wasChanged('status') && $order->status === 'completed') {
            $this->updateMenuStats($order);
        }

        // If order is cancelled, revert the stats
        if ($order->wasChanged('status') && $order->status === 'cancelled') {
            $this->revertMenuStats($order);
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        // Revert stats when order is deleted
        $this->revertMenuStats($order);
    }

    /**
     * Update menu statistics based on order
     */
    private function updateMenuStats(Order $order): void
    {
        if ($order->status !== 'completed') {
            return;
        }

        $orderItems = OrderItem::where('order_id', $order->id)->get();

        foreach ($orderItems as $item) {
            Menu::where('id', $item->menu_id)->update([
                'order_count' => DB::raw('order_count + ' . $item->quantity),
                'total_revenue' => DB::raw('total_revenue + ' . ($item->quantity * $item->price))
            ]);
        }
    }

    /**
     * Revert menu statistics
     */
    private function revertMenuStats(Order $order): void
    {
        $orderItems = OrderItem::where('order_id', $order->id)->get();

        foreach ($orderItems as $item) {
            Menu::where('id', $item->menu_id)->update([
                'order_count' => DB::raw('GREATEST(order_count - ' . $item->quantity . ', 0)'),
                'total_revenue' => DB::raw('GREATEST(total_revenue - ' . ($item->quantity * $item->price) . ', 0)')
            ]);
        }
    }

    /**
     * Notify tenant about new preorder for stock planning
     */
    private function notifyTenantForPreorder(Order $order): void
    {
        try {
            $order->load('orderItems.menu');
            $tenant = $order->tenant;

            if (!$tenant || !$tenant->user) {
                return;
            }

            // Group items by menu and calculate total needed for delivery date
            $itemsByMenu = [];
            foreach ($order->orderItems as $orderItem) {
                $menu = $orderItem->menu;
                if ($menu && $menu->isHeavyMeal()) {
                    $menuId = $menu->id;
                    if (!isset($itemsByMenu[$menuId])) {
                        $itemsByMenu[$menuId] = [
                            'menu' => $menu,
                            'quantity' => 0,
                            'total_quantity_today' => 0,
                            'total_quantity_tomorrow' => 0
                        ];
                    }

                    $itemsByMenu[$menuId]['quantity'] += $orderItem->quantity;

                    // Calculate total needed for this delivery date
                    $deliveryDate = $order->delivery_date;
                    if ($deliveryDate) {
                        $totalOrders = Order::where('tenant_id', $tenant->id)
                            ->where('order_type', 'preorder')
                            ->whereDate('delivery_date', $deliveryDate)
                            ->where('status', '!=', Order::STATUS_DIBATALKAN)
                            ->with('orderItems')
                            ->get()
                            ->sum(function ($order) use ($menuId) {
                                return $order->orderItems
                                    ->where('menu_id', $menuId)
                                    ->sum('quantity');
                            });

                        if ($deliveryDate->isToday()) {
                            $itemsByMenu[$menuId]['total_quantity_today'] = $totalOrders;
                        } elseif ($deliveryDate->isTomorrow()) {
                            $itemsByMenu[$menuId]['total_quantity_tomorrow'] = $totalOrders;
                        }
                    }
                }
            }

            if (!empty($itemsByMenu)) {
                // Send notification to tenant
                $tenant->user->notify(new PreorderNotification($order, $itemsByMenu));

                // Log for analytics
                Log::info('Pre-order notification sent', [
                    'order_id' => $order->id,
                    'tenant_id' => $tenant->id,
                    'items_count' => count($itemsByMenu),
                    'delivery_date' => $order->delivery_date
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send preorder notification: ' . $e->getMessage(), [
                'order_id' => $order->id
            ]);
        }
    }
}