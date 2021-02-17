<?php

namespace DrewRoberts\Blog\Policies;

use DrewRoberts\Blog\Models\Page;
use Illuminate\Auth\Access\HandlesAuthorization;
use Tipoff\Support\Contracts\Models\UserInterface;

class PagePolicy
{
    use HandlesAuthorization;

    public function viewAny(UserInterface $user)
    {
        return $user->hasPermissionTo('view pages');
    }

    public function view(UserInterface $user, Page $page)
    {
        return $user->hasPermissionTo('view pages');
    }

    public function create(UserInterface $user)
    {
        return $user->hasPermissionTo('create pages');
    }

    public function update(UserInterface $user, Page $page)
    {
        return $user->hasPermissionTo('update pages');
    }
}
