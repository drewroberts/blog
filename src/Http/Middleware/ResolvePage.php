<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Http\Middleware;

use Closure;
use DrewRoberts\Blog\Models\Page;
use DrewRoberts\Blog\Services\PageResolver;

class ResolvePage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $page = app(PageResolver::class)->resolve($request->route('page'));
        $request->route()->setParameter('page', $page);

        return $next($request);
    }

}
