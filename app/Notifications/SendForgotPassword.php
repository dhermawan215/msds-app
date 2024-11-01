<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendForgotPassword extends Notification
{
    use Queueable;
    protected $content;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from($address = 'noreply@zekindo.co.id', $name = 'noreply@zekindo.co.id')
            ->subject('Forgot password? Please reset your password')
            ->greeting('Hello,' . $this->content['user'])
            ->line('Please reset your password with new password, if you lost your password.')
            ->action('Reset password', route('forgot_password.change_password', $this->content['token']))
            ->line('The link is available for 10 minutes')
            ->line('Have a nice day');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
