<?php

namespace DrewRoberts\Blog\Policies;

use Tipoff\Support\Contracts\Models\UserInterface;
use DrewRoberts\Blog\Models\Page;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  Tipoff\Support\Contracts\Models\UserInterface  $user
     * @return mixed
     */
    public function viewAny(UserInterface $user)
    {
        return $user->hasPermissionTo('view pages') ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  Tipoff\Support\Contracts\Models\UserInterface  $user
     * @param  \DrewRoberts\Blog\Models\Page  $page
     * @return mixed
     */
    public function view(UserInterface $user, Page $page)
    {
        return $user->hasPermissionTo('view pages') ? true : false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  Tipoff\Support\Contracts\Models\UserInterface  $user
     * @return mixed
     */
    public function create(UserInterface $user)
    {
        return $user->hasPermissionTo('create pages') ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  Tipoff\Support\Contracts\Models\UserInterface  $user
     * @param  \DrewRoberts\Blog\Models\Page  $page
     * @return mixed
     */
    public function update(UserInterface $user, Page $page)
    {
        return $user->hasPermissionTo('update pages') ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  Tipoff\Support\Contracts\Models\UserInterface  $user
     * @param  \DrewRoberts\Blog\Models\Page  $page
     * @return mixed
     */
    public function delete(UserInterface $user, Page $page)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  Tipoff\Support\Contracts\Models\UserInterface  $user
     * @param  \DrewRoberts\Blog\Models\Page  $page
     * @return mixed
     */
    public function restore(UserInterface $user, Page $page)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  Tipoff\Support\Contracts\Models\UserInterface  $user
     * @param  \DrewRoberts\Blog\Models\Page  $page
     * @return mixed
     */
    public function forceDelete(UserInterface $user, Page $page)
    {
        return false;
    }
}
