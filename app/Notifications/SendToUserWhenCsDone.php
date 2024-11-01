<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendToUserWhenCsDone extends Notification
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
            ->from($address = 'noreply@zekindo.co.id', $name = $this->content['sender'])
            ->subject('Sample-(' . $this->content['sample_subject'] . ' ' . $this->content['sample_id'] . ') ready to be sent using expedition')
            ->greeting('Hello,' . $this->content['requestor'])
            ->line('Sample is ready to be sent with expedition. Detail sample request as below:')
            ->line('Sample ID: ' . $this->content['sample_id'])
            ->line('Subject: ' . $this->content['sample_subject'])
            ->line('Request date: ' . $this->content['request_date'])
            ->line('Delivery date: ' . $this->content['delivery_date'])
            ->line('CS note: ' . $this->content['cs_note'])
            ->line('Deliverier: ' . $this->content['deliverier'])
            ->line('Receipt: ' . $this->content['receipt'])
            ->line('Delivery method: Expedition')
            ->line('The sample includes the msds/pds documents, please login to system for download it.')
            ->line('For information this sample please login to system.')
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
