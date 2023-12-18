<?php

namespace App\Notifications;
use App\Models\Bagoong;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DownloadNotification extends Notification
{
    use Queueable;

    protected $bagoong;

    /**
     * Create a new notification instance.
     */
    public function __construct(Bagoong $bagoong)
    {
        $this->bagoong = $bagoong;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->line('Thank you for ordering! Your choice is greatly appreciated.')
        ->line('We trust that your purchase of "' . $this->bagoong->name . '" will bring value and elevate your experience.')
        ->action('Return to the store', url('/'))
        ->line('Enjoy your purchase!');

    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
