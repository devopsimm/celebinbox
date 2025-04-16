<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewPostNotification extends Notification
{
    use Queueable;

    public $message;
    public $url;  // Store the link here

    // Constructor to pass the message and link
    public function __construct($message, $url)
    {
        $this->message = $message;
        $this->url = $url;
    }

    // Define the channels to be used for the notification (we're using database here)
    public function via($notifiable)
    {
        return ['database'];
    }

    // The data to be stored in the database (including the link)
    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
            'url' => $this->url,  // Store the URL here
        ];
    }
}
