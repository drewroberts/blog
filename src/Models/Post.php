<?php

namespace DrewRoberts\Blog\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (auth()->check()) {
                $post->creator_id = auth()->id();
            }
        });

        static::saving(function ($post) {
            if (empty($post->author_id)) { // Can specify a different author for a post than Auth user
                $post->author_id = auth()->user()->id;
            }
            if (empty($post->series_id)) {
                throw new \Exception('Blog post must be assigned to a series.');
            }
            if (auth()->check()) {
                $post->updater_id = auth()->id();
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
        return $this->belongsTo(\App\Models\User::class, 'author_id');
    }

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function topic()
    {
        return $this->hasOneThrough(
            Topic::class,
            Series::class,
            'id',
            'id',
            'series_id',
            'topic_id'
        );
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
        return $this->belongsTo(\App\Models\User::class, 'creator_id');
    }

    public function updater()
    {
        return $this->belongsTo(\App\Models\User::class, 'updater_id');
    }

    public function isPublished()
    {
        return $this->published_at->isPast();
    }

    protected static function newFactory()
    {
        return \Database\Factories\DrewRoberts\Blog\PostFactory::new();
    }
}
