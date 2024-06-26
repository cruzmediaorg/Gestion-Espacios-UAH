<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SuccessNotification extends Notification
{
    use Queueable;

    private string $success;

    /**
     * Create a new notification instance.
     */
    public function __construct($success)
    {
        $this->success = $success;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'tipo' => 'success', // 'info', 'success', 'warning', 'error
            'message' => $this->success,
        ];
    }
}
