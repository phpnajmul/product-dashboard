<?php

namespace App\Observers;

use App\Models\User;
use Laravel\Nova\Notifications\NovaNotification;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $this->getNovaNotification($user, 'New user', 'success');
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $this->getNovaNotification($user, 'Updated user', 'info');
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        $this->getNovaNotification($user, 'Deleted user', 'error');
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        $this->getNovaNotification($user, 'Restored user', 'success');
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        $this->getNovaNotification($user, 'Force Deleted user', 'error');
    }

    /**
     * @param User $user
     * @return void
     */
    private function getNovaNotification($user, $message, $type): void
    {
        foreach (User::all() as $u) {
            $u->notify(NovaNotification::make()
                ->message($message . ' ' . $user->name)
                ->icon('user')
                ->type($type));
        }
    }
}
