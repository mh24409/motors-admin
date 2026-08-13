<?php

namespace Modules\Admin\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Admin\Models\Admin;
use Modules\Api\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(Admin $admin): bool
    {
        return $admin->can('view_any_user');
    }

    public function view(Admin $admin, User $user): bool
    {
        return $admin->can('view_user');
    }

    public function create(Admin $admin): bool
    {
        return $admin->can('create_user');
    }

    public function update(Admin $admin, User $user): bool
    {
        return $admin->can('update_user');
    }

    public function delete(Admin $admin, User $user): bool
    {
        return $admin->can('delete_user');
    }

    public function deleteAny(Admin $admin): bool
    {
        return $admin->can('delete_any_user');
    }

    public function restore(Admin $admin, User $user): bool
    {
        return $admin->can('restore_user');
    }

    public function restoreAny(Admin $admin): bool
    {
        return $admin->can('restore_any_user');
    }

    public function forceDelete(Admin $admin, User $user): bool
    {
        return $admin->can('force_delete_user');
    }

    public function forceDeleteAny(Admin $admin): bool
    {
        return $admin->can('force_delete_any_user');
    }

    public function replicate(Admin $admin, User $user): bool
    {
        return $admin->can('replicate_user');
    }

    public function reorder(Admin $admin): bool
    {
        return $admin->can('reorder_user');
    }
}
