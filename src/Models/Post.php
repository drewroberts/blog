<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class Post extends BaseModel
{
    use SoftDeletes, HasCreator, HasUpdater, HasPackageFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($post) {
            if (empty($post->author_id)) { // Can specify a different author for a post than Auth user
                $post->author_id = auth()->user()->id;
            }
            if (! empty($post->series_id)) {
                $post->topic_id = $post->series->topic_id;
            }
            if (empty($post->pageviews)) {
                $post->pageviews = 0;
            }
            if (empty($post->published_at)) {
                $post->published_at = Carbon::now();
            }
        });

        static::addGlobalScope('published', function (Builder $builder) {
            $builder->where('published_at', '<', now());
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
    public function getblogPathAttribute()
    {
        // @todo - Set blog path based on config options
        return "/{$this->topic->slug}/{$this->series->slug}/{$this->slug}";
    }

    /**
     * Get a string path for the blog post image.
     *
     * @return string
     */
    public function getImagePathAttribute()
    {
        return $this->image === null ?
            url('img/ogimage.jpg') :
            'https://res.cloudinary.com/' . env('CLOUDINARY_CLOUD_NAME') . '/t_cover/' . $this->image->filename . '.jpg';
    }

    /**
     * Get a string path for the blog post image's placeholder.
     *
     * @return string
     */
    public function getPlaceholderPathAttribute()
    {
        $this->image === null ?
            url('img/ogimage.jpg') :
            'https://res.cloudinary.com/' . env('CLOUDINARY_CLOUD_NAME') . '/t_coverplaceholder/' . $this->image->filename . '.jpg';
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

    public function isPublished()
    {
        return $this->published_at->isPast();
    }
}
