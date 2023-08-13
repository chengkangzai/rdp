<?php

namespace App\Policies;

use App\Models\Pc;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PcPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Pc $pc): bool
    {
        return $user->id === $pc->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Pc $pc): bool
    {
        return $user->id === $pc->user_id;
    }

    public function delete(User $user, Pc $pc): bool
    {
        return $user->id === $pc->user_id;
    }

    public function restore(User $user, Pc $pc): bool
    {
        return $user->id === $pc->user_id;
    }

    public function forceDelete(User $user, Pc $pc): bool
    {
        return false;
    }
}
