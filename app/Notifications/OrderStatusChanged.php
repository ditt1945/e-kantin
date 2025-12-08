<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Order $order,
        public string $previousStatus,
        public string $newStatus
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $statusLabel = match($this->newStatus) {
            'diproses' => 'Sedang Diproses',
            'selesai' => 'Siap Diambil',
            'dibatalkan' => 'Dibatalkan',
            default => ucfirst($this->newStatus),
        };

        return (new MailMessage)
            ->subject('Status Pesanan Berubah - ' . $this->order->kode_pesanan)
            ->greeting('Halo ' . $notifiable->name . '!')
            ->line('Status pesanan Anda telah berubah.')
            ->line('Kode Pesanan: ' . $this->order->kode_pesanan)
            ->line('Status Baru: ' . $statusLabel)
            ->action('Lihat Detail', route('customer.orders'))
            ->line('Terima kasih telah menggunakan e-Kantin!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'kode_pesanan' => $this->order->kode_pesanan,
            'status' => $this->newStatus,
            'message' => 'Status pesanan Anda berubah menjadi ' . $this->newStatus,
            'type' => 'order_status_changed',
        ];
    }
}
