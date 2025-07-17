<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RabCase;
use Illuminate\Auth\Access\HandlesAuthorization;

class RabCasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_rab::case');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, RabCase $rabCase): bool
    {
        return $user->can('view_rab::case');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_rab::case');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RabCase $rabCase): bool
    {
        return $user->can('update_rab::case');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RabCase $rabCase): bool
    {
        return $user->can('delete_rab::case');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_rab::case');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, RabCase $rabCase): bool
    {
        return $user->can('force_delete_rab::case');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_rab::case');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, RabCase $rabCase): bool
    {
        return $user->can('restore_rab::case');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_rab::case');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, RabCase $rabCase): bool
    {
        return $user->can('replicate_rab::case');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_rab::case');
    }
}
