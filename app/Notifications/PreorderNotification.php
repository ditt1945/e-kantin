<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PreorderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private $order,
        private array $itemsByMenu
    ) {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $deliveryDate = $this->order->delivery_date ? $this->order->delivery_date->format('d/m/Y') : 'N/A';

        return (new MailMessage)
            ->subject('🍛 Pre-Order Baru - ' . $this->order->tenant->nama_tenant)
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Anda memiliki pre-order baru untuk makanan berat:')
            ->line('**Order ID:** ' . $this->order->kode_pesanan)
            ->line('**Tanggal Pengambilan:** ' . $deliveryDate)
            ->line('**Jumlah Menu:** ' . count($this->itemsByMenu))
            ->line('**Total Nilai:** Rp ' . number_format($this->order->total_harga, 0, ',', '.'))
            ->action('Lihat Detail Pre-Order', url('/tenant/orders/' . $this->order->id))
            ->line('Persiapkan stok yang cukup untuk pre-order ini agar tidak kehabisan!')
            ->line('Terima kasih telah menggunakan Kantin-E!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $deliveryDate = $this->order->delivery_date ? $this->order->delivery_date->format('d/m/Y') : 'N/A';

        return [
            'title' => 'Pre-Order Baru',
            'message' => 'Ada pre-order ' . count($this->itemsByMenu) . ' menu untuk ' . $deliveryDate,
            'order_id' => $this->order->id,
            'order_code' => $this->order->kode_pesanan,
            'delivery_date' => $deliveryDate,
            'total_amount' => $this->order->total_harga,
            'items_count' => count($this->itemsByMenu),
            'tenant_name' => $this->order->tenant->nama_tenant,
            'type' => 'preorder',
            'icon' => 'fas fa-clock',
            'color' => 'warning'
        ];
    }
}
