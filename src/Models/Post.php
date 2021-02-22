<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Models;

use DrewRoberts\Blog\Traits\HasPageViews;
use DrewRoberts\Blog\Traits\Publishable;
use DrewRoberts\Media\Traits\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class Post extends BaseModel
{
    use SoftDeletes,
        HasCreator,
        HasUpdater,
        HasPackageFactory,
        Publishable,
        HasMedia,
        HasPageViews;

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($post) {
            // Can specify a different author for a post than Auth user
            if (empty($post->author_id)) {
                $post->author_id = auth()->user()->id;
            }

            if (! empty($post->series_id)) {
                $post->topic_id = $post->series->topic_id;
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get a string path for the blog post.
     *
     * @return string
     * @todo use config file for alternate paths
     */
    public function getPathAttribute()
    {
        // @todo - Set blog path based on config options
        return "/{$this->topic->slug}/{$this->series->slug}/{$this->slug}";
    }

    public function author()
    {
        return $this->belongsTo(app('user'), 'author_id');
    }

    public function topic()
    {
        return $this->belongsTo(app('topic'));
    }

    public function series()
    {
        return $this->belongsTo(app('series'));
    }
}
