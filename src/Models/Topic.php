<?php

namespace DrewRoberts\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $guarded = ['id'];

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
     * Get a string path for the topic.
     *
     * @return string
     * @todo use config file for alternate paths
     */
    public function getPathAttribute()
    {
        return "/{$this->slug}";
    }

    public function seriess()
    {
        return $this->hasMany(Series::class);
    }

    public function posts()
    {
        return $this->hasManyThrough(Post::class, Series::class);
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
