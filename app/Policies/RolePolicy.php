<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Employee  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Employee $user)
    {
        return $user->can('view_any_role');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Employee  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Employee $user)
    {
        return $user->can('view_role');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Employee  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Employee $user)
    {
        return $user->can('create_role');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Employee  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Employee $user, Role $role)
    {
        ray("Fired");
        ray($role);
        if ($role->name == 'owner') {
            return false;
        }
        return $user->can('update_role');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Employee  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Employee $user, Role $role)
    {
        if ($role->name == 'owner') {
            return false;
        }
        return $user->can('delete_role');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\Employee  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(Employee $user)
    {
        return $user->can('delete_any_role');
    }

}