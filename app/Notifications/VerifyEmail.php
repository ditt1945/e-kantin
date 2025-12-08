<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends Notification implements ShouldQueue
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verifikasi Email e-Kantin')
            ->greeting('Selamat datang di e-Kantin!')
            ->line('Terima kasih telah mendaftar. Silakan verifikasi email Anda untuk melanjutkan.')
            ->action('Verifikasi Email', $verificationUrl)
            ->line('Link verifikasi ini akan berlaku selama 60 menit.')
            ->line('Jika Anda tidak membuat akun ini, abaikan email ini.')
            ->line('Salam,')
            ->line('Tim e-Kantin');
    }

    protected function verificationUrl($notifiable): string
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
        );
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Silakan verifikasi email Anda',
        ];
    }
}
