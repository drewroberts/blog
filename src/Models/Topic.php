<?php

namespace DrewRoberts\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasUpdater;

class Topic extends Model
{
    use HasPackageFactory;    
    use HasCreator;
    use HasUpdater;

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

}
