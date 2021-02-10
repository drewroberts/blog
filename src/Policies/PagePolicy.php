<?php

namespace DrewRoberts\Blog\Policies;

use App\Models\User;
use DrewRoberts\Blog\Models\Page;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('view pages') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \DrewRoberts\Blog\Models\Page  $page
     * @return mixed
     */
    public function view(User $user, Page $page)
    {
        return $user->hasPermissionTo('view pages') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create pages') ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \DrewRoberts\Blog\Models\Page  $page
     * @return mixed
     */
    public function update(User $user, Page $page)
    {
        return $user->hasPermissionTo('update pages') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \DrewRoberts\Blog\Models\Page  $page
     * @return mixed
     */
    public function delete(User $user, Page $page)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \DrewRoberts\Blog\Models\Page  $page
     * @return mixed
     */
    public function restore(User $user, Page $page)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \DrewRoberts\Blog\Models\Page  $page
     * @return mixed
     */
    public function forceDelete(User $user, Page $page)
    {
        return false;
    }
}
