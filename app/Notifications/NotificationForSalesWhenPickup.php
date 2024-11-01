<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificationForSalesWhenPickup extends Notification
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
            ->subject('Sample-(' . $this->content['sample_subject'] . ' ' . $this->content['sample_id'] . ') ready to pick up')
            ->greeting('Hello,' . $this->content['requestor'])
            ->line('Sample is ready to pick up. Detail sample request as below:')
            ->line('Sample ID: ' . $this->content['sample_id'])
            ->line('Subject: ' . $this->content['sample_subject'])
            ->line('Request date: ' . $this->content['request_date'])
            ->line('Delivery date: ' . $this->content['delivery_date'])
            ->line('Sample PIC note: ' . $this->content['sample_pic_note'])
            ->line('Delivery method: Pick up')
            ->line('The sample includes the msds/pds documents, please login to system for download it.')
            ->line('For information this sample please login to system.')
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
