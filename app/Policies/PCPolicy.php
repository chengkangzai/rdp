<?php

namespace App\Policies;

use App\Models\PC;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PCPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, PC $PC): bool
    {
        return $user->id === $PC->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, PC $PC): bool
    {
        return $user->id === $PC->user_id;
    }

    public function delete(User $user, PC $PC): bool
    {
        return $user->id === $PC->user_id;
    }

    public function restore(User $user, PC $PC): bool
    {
        return $user->id === $PC->user_id;
    }

    public function forceDelete(User $user, PC $PC): bool
    {
        return false;
    }
}
