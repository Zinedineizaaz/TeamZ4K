<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    // Terima Token dari User Model
    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Generate Link Reset Password
        // Pastikan url ini sesuai dengan route Laravel kamu
        $url = url('/password/reset/' . $this->token . '?email=' . $notifiable->getEmailForPasswordReset());

        return (new MailMessage)
            // PENTING: Paksa "From" address sama dengan username Gmail di .env
            // GANTI 'emailaslikamu@gmail.com' DENGAN EMAIL YANG SAMA DI .ENV!
            ->from(env('MAIL_USERNAME'), 'Dimsaykuu Admin') 
            ->subject('Reset Password Akun Dimsaykuu')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Kamu menerima email ini karena kami menerima permintaan reset password untuk akunmu.')
            ->action('Reset Password Sekarang', $url)
            ->line('Link ini akan kadaluarsa dalam 60 menit.')
            ->line('Jika kamu tidak merasa meminta reset password, abaikan saja email ini.');
    }
}