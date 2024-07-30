<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SamplePicAssign extends Notification
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
            ->subject('Sample-(' . $this->content['sample_subject'] . ' ' . $this->content['sample_id'] . ') assign to you')
            ->greeting('Hello,' . $this->content['rnd_name'])
            ->line($this->content['sample_pic'] . ' is assign sample request to you, with detail as:')
            ->line('Sample ID: ' . $this->content['sample_id'])
            ->line('Subject: ' . $this->content['sample_subject'])
            ->line('Requestor: ' . $this->content['requestor'])
            ->line('Required date: ' . $this->content['required_date'])
            ->line('Delivery date: ' . $this->content['delivery_date'])
            ->line('Sample PIC note: ' . $this->content['sample_pic_note'])
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
