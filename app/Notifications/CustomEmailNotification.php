<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CustomEmailNotification extends Notification
{
    use Queueable;
    private $message;
    private $attachments;
    
    /**
     * Create a new notification instance.
     *
     * @param $message
     * @param $attachments
     */
    public function __construct($message, $attachments)
    {
        $this->message = $message;
        $this->attachments = $attachments;
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
        $email = (new MailMessage)
                    ->line('Hello')
                    ->line($this->message)
                    ->line('Thank you for using our application!');
        foreach($this->attachments as $filePath => $fileParameters){
            $email->attach($filePath, $fileParameters);
        }
        
        return $email;
        
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
