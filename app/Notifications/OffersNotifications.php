<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Notification;

class OffersNotifications extends Notification
{
    use Queueable;
    private $offerData;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($offerData)
    {
        //
        $this->offerData = $offerData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            ->name($this->offerData['name'])
            ->line($this->offerData['body'])
            ->action($this->offerData['offerText'], $this->offerData['offerUrl'])
            ->line($this->offerData['thanks']);
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
            'offer_id' => $this->offerData['offer_id']
        ];
    }
}
