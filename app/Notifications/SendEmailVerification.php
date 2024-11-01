<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendEmailVerification extends Notification
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
            ->subject('Welcome to Lab Service System by Zekindo Chemicals')
            ->greeting('Hello,' . $this->content['user'])
            ->line('Please activate your account to access Lab Service System')
            ->action('Activate', route('activation', $this->content['token']))
            ->line('Activate token available only 30 minutes after you receive the email.')
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
