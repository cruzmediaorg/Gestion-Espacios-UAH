<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Log;

class NotificationCreatedEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $tipo;
    public $message;
    public $notification;

    public function __construct(private User $user)
    {
        $this->notification = $user->notifications->first();
        if (!$this->notification) {
            return;
        }
        $this->tipo = $this->notification->data['tipo'];
        $this->message = $this->notification->data['message'];
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('users.' . $this->user->id),
        ];
    }
}
