<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Models;

use DrewRoberts\Blog\Traits\HasMedia;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class Topic extends BaseModel
{
    use HasCreator,
        HasUpdater,
        HasPackageFactory,
        HasMedia;

    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($topic) {
            if (empty($topic->pageviews)) {
                $topic->pageviews = 0;
            }
        });
    }

    /**
     * Get a string path for the topic.
     *
     * @return string
     * @todo use config file for alternate paths
     */
    public function getPathAttribute()
    {
        return "/{$this->slug}";
    }

    public function series()
    {
        return $this->hasMany(app('series'));
    }

    public function posts()
    {
        return $this->hasManyThrough(app('post'), app('series'));
    }
}
