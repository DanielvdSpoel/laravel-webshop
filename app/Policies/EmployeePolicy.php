<?php

namespace App\Policies;

use App\Models\Employee;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeePolicy
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
        return $user->can('view_any_employee');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Employee  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Employee $user)
    {
        return $user->can('view_employee');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Employee  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Employee $user)
    {
        return $user->can('create_employee');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Employee  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Employee $user)
    {
        return $user->can('update_employee');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Employee  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Employee $user)
    {
        return $user->can('delete_employee');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\Employee  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(Employee $user)
    {
        return $user->can('delete_any_employee');
    }
}
