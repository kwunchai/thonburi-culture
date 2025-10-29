<?php

namespace App\Policies;

use App\Models\IntellectualProperty;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class IntellectualPropertyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, IntellectualProperty $intellectualProperty): bool
    {
        return $user->id === $intellectualProperty->owner_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, IntellectualProperty $intellectualProperty): bool
    {
        return $user->id === $intellectualProperty->owner_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, IntellectualProperty $intellectualProperty): bool
    {
        return $user->id === $intellectualProperty->owner_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, IntellectualProperty $intellectualProperty): bool
    {
        return $user->id === $intellectualProperty->owner_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, IntellectualProperty $intellectualProperty): bool
    {
        return $user->id === $intellectualProperty->owner_id;
    }
}
