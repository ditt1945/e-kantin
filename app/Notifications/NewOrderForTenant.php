<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewOrderForTenant extends Notification
{
    use Queueable;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'kode' => $this->order->kode_pesanan,
            'total' => $this->order->total_harga,
            'customer_name' => optional($this->order->user)->name,
            'message' => 'Pesanan baru masuk: ' . ($this->order->kode_pesanan ?? ''),
            'created_at' => $this->order->created_at?->toDateTimeString(),
        ];
    }
}
