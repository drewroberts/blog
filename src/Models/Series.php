<?php

namespace DrewRoberts\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $guarded = ['id'];

    protected $table = 'series';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($topic) {
            if (auth()->check()) {
                $topic->creator_id = auth()->id();
            }
        });

        static::saving(function ($topic) {
            if (auth()->check()) {
                $topic->updater_id = auth()->id();
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
        return $this->belongsTo(Topic::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function image()
    {
        return $this->belongsTo(\DrewRoberts\Media\Models\Image::class);
    }

    public function ogimage()
    {
        return $this->belongsTo(\DrewRoberts\Media\Models\Image::class, 'ogimage_id');
    }

    public function video()
    {
        return $this->belongsTo(\DrewRoberts\Media\Models\Video::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updater_id');
    }
}
