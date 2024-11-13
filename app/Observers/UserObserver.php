<?php

namespace App\Observers;

use App\Models\User;
use App\Events\UserCreated;
use App\Jobs\CreateAccountJob;

class UserObserver
{
    public function created(User $user)
    {
        // Déclencher l'événement
        event(new UserCreated($user));

        // Dispatch le job de création de compte
        CreateAccountJob::dispatch($user);
    }
}