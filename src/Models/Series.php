<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Models;

use DrewRoberts\Blog\Traits\HasMetaData;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class Series extends BaseModel
{
    use HasCreator,
        HasUpdater,
        HasPackageFactory,
        HasMetaData;

    protected $guarded = ['id'];

    protected $table = 'series';

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($series) {
            if (empty($series->pageviews)) {
                $series->pageviews = 0;
            }
        });
    }

    /**
     * Get a string path for the series.
     *
     * @return string
     * @todo use config file for alternate paths
     */
    public function getPathAttribute()
    {
        return "/{$this->topic->slug}/{$this->slug}";
    }

    public function topic()
    {
        return $this->belongsTo(app('topic'));
    }

    public function posts()
    {
        return $this->hasMany(app('post'));
    }
}
