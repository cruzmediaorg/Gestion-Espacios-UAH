<?php

namespace App\Listeners;

use App\Console\Commands\SendNotification;
use App\Events\NotificationCreatedEvent;
use App\Models\User;
use Artisan;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Notifications\Events\NotificationSending;
use Log;
use Notification;

class NotificationEventListener
{

    /**
     * Handle the event.
     */
    public function handle(NotificationSending $event)
    {
        $user = User::find($event->notifiable->id);
        Artisan::call('SendNotification', ['user' => $user->id]);
    }
}
