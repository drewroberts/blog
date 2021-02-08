<?php

namespace DrewRoberts\Blog\Models;

use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasPackageFactory;

class Series extends BaseModel
{
    use HasPackageFactory;

    protected $guarded = ['id'];

    protected $table = 'series';

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($series) {
            if (auth()->check()) {
                $series->creator_id = auth()->id();
            }
        });

        static::saving(function ($series) {
            if (empty($series->pageviews)) {
                $series->pageviews = 0;
            }
            if (auth()->check()) {
                $series->updater_id = auth()->id();
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

    public function image()
    {
        return $this->belongsTo(app('image'));
    }

    public function ogimage()
    {
        return $this->belongsTo(app('image'), 'ogimage_id');
    }

    public function video()
    {
        return $this->belongsTo(app('video'));
    }

    public function creator()
    {
        return $this->belongsTo(app('user'), 'creator_id');
    }

    public function updater()
    {
        return $this->belongsTo(app('user'), 'updater_id');
    }
}
