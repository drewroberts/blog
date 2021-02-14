<?php

namespace DrewRoberts\Blog\Policies;

use Tipoff\Support\Contracts\Models\UserInterface;
use DrewRoberts\Blog\Models\Page;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    public function viewAny(UserInterface $user)
    {
        return $user->hasPermissionTo('view pages') ? true : false;
    }

    public function view(UserInterface $user, Page $page)
    {
        return $user->hasPermissionTo('view pages') ? true : false;
    }

    public function create(UserInterface $user)
    {
        return $user->hasPermissionTo('create pages') ? true : false;
    }

    public function update(UserInterface $user, Page $page)
    {
        return $user->hasPermissionTo('update pages') ? true : false;
    }

    public function delete(UserInterface $user, Page $page)
    {
        return false;
    }

    public function restore(UserInterface $user, Page $page)
    {
        return false;
    }

    public function forceDelete(UserInterface $user, Page $page)
    {
        return false;
    }
}
