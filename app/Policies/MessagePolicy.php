<?php

namespace App\Policies;

use App\Models\Message;
use App\Models\User;

class MessagePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPerm('admin-access-messages');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Message $message): bool
    {
        if ($user->hasPerm('admin-access-messages')) {
            return true;
        }

        return $user->hasPerm('access-messages');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        dd($user->hasPerm('create-messages'));

        return $user->hasPerm('create-messages');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Message $message): bool
    {
        if ($user->hasPerm('admin-update-messages')) {
            return true;
        }

        return $user->hasPerm('update-messages') && $user->isAuthor($message);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Message $message): bool
    {
        if ($user->hasPerm('admin-remove-messages')) {
            return true;
        }

        return $user->hasPerm('remove-messages') && $user->isAuthor($message);
    }
}
