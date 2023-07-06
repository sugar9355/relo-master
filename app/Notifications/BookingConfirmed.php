<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BookingConfirmed extends Notification
{
    use Queueable;

    public $average;
    public $date;
    public $time;
    public $id;

    /**
     * Create a new notification instance.
     *
     * @param $average
     * @param $date
     * @param $time
     * @param $id
     */
    public function __construct($average, $date, $time, $id)
    {
        $this->average = $average;
        $this->date = $date;
        $this->time = $time;
        $this->id = $id;
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
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line("Hello.")
            ->line("Your order has been approved")
            ->line("Date: ". $this->date)
            ->line("Time: ". $this->time)
            ->action("See your Order", url("/trip/show/".$this->id))
            ->line("Thank you for order");
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
