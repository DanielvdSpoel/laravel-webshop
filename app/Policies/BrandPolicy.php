<?php

namespace App\Policies;

use App\Models\Brand;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BrandPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Brand  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Employee $user)
    {
        return $user->can('view_any_brand');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Brand  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Brand $user)
    {
        return $user->can('view_brand');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Brand  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Brand $user)
    {
        return $user->can('create_brand');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Brand  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Brand $user)
    {
        return $user->can('update_brand');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Brand  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Brand $user)
    {
        return $user->can('delete_brand');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\Brand  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(Brand $user)
    {
        return $user->can('delete_any_brand');
    }
}
