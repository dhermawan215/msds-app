<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendEmailWhenSampleFinish extends Notification
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
            ->from($address = 'noreply@zekindo.co.id', $name = $this->content['sample_pic'])
            ->subject('Sample-(' . $this->content['sample_subject'] . ' ' . $this->content['sample_id'] . ') is ready')
            ->greeting('Hello,' . $this->content['sample_pic'])
            ->line('The sample has been finished by sample creator, with detail as:')
            ->line('Sample ID: ' . $this->content['sample_id'])
            ->line('Subject: ' . $this->content['sample_subject'])
            ->line('Request date: ' . $this->content['request_date'])
            ->line('Delivery date: ' . $this->content['delivery_date'])
            ->line('Sample Creator note: ' . $this->content['sample_creator_note'])
            ->line('Sample Creator finished: ' . $this->content['sample_creator_time'])
            ->line('For next step and information about sample please login to system.')
            ->action('Show detail', route('sample_request.preview', $this->content['sample_token']))
            ->line('Show detail feature available only 30 minutes after you receive the email.')
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
