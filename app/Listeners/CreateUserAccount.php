<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class CreateUserAccount implements ShouldQueue
{
    public function handle(UserCreated $event)
    {
        Log::info('Nouveau utilisateur créé : ' . $event->user->email);
    }
}