<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserRegistered extends Notification
{
    use Queueable;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Registrasi Berhasil')
                    ->greeting('Halo, ' . $this->user->name . '!')
                    ->line('Anda telah berhasil melakukan registrasi.')
                    ->line('Detail akun Anda:')
                    ->line('Email: ' . $this->user->email)
                    ->line('Nama: ' . $this->user->name)
                    ->action('Login Sekarang', url('/login'))
                    ->line('Terima kasih telah mendaftar di aplikasi kami!');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
