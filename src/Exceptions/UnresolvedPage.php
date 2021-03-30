<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Exceptions;

use Exception;

class UnresolvedPage extends Exception /*implements LocationException*/
{
    public function __construct()
    {
        parent::__construct("Could not resolve page");
    }

    public function render()
    {
        return view('pages::page_select');
    }
}
