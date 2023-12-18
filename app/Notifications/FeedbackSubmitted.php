<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class FeedbackSubmitted extends Notification
{
    use Queueable;

    /**
     * The feedback instance.
     *
     * @var \App\Models\Feedback
     */
    public $feedback;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Feedback $feedback
     */
    public function __construct($feedback)
    {
        $this->feedback = $feedback;
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

        $userName = Auth::user()->name ?? 'Unknown User';

        $feedbackContent = $this->feedback->content;

        return (new MailMessage)
            ->line('New Feedback Submitted:')
            ->line("From: $userName")
            ->line($feedbackContent);

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
