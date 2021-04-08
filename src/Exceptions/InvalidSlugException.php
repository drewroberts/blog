<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Exceptions;

use Laravel\Nova\Nova;
use Throwable;

class InvalidSlugException extends \LogicException implements BlogException
{
    public function __construct($code = 0, Throwable $previous = null)
    {
        parent::__construct('Slug is not allowed.', $code, $previous);
    }

    public static function checkNovaRestrictions(string $slug)
    {
        // Prevent root pages from conflicting with Nova
        $novaRestrictions = [
            trim(Nova::path(), '/'),
            'nova-api',
            'nova-vendor',
        ];

        throw_if(in_array($slug, $novaRestrictions), static::class);
    }
}
