<?php

namespace App\Notifications;

use App\Enums\CmnEnum;
use App\Repositories\RoleAndPermissions\UserRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    private $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = config('app.fe_url') . '/reset-password?token=' . $this->token . '&email=' . $notifiable->getEmailForPasswordReset();
        return (new MailMessage)
            ->subject(Lang::get('mail.resetPassword.subject'))
            ->line(Lang::get('mail.resetPassword.line1'))
            ->action(Lang::get('mail.resetPassword.actionText'), $url)
            ->line(Lang::get('mail.resetPassword.line2', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
            ->line(Lang::get('mail.resetPassword.line3'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
