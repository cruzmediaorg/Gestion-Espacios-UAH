<?php

namespace App\Console\Commands;

use App\Events\NotificationCreatedEvent;
use App\Models\User;
use Illuminate\Console\Command;
use Log;

class SendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendNotification {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::find($this->argument('user'));
        Log::info('Enviando notificación a ' . $user->name);

        event(new NotificationCreatedEvent($user));
    }
}
