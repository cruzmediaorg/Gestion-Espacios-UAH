<?php

namespace App\Notifications;

use App\Models\Curso;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CursoCreadoNotification extends Notification
{
    use Queueable;

    private Curso $curso;

    /**
     * Create a new notification instance.
     */
    public function __construct(Curso $curso)
    {
        $this->curso = $curso;
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
            'curso' => $this->curso,
            'message' => 'Se ha creado el curso ' . $this->curso->nombre . ' con éxito',
        ];
    }
}
