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

    protected $dates = [
        'published_at',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->author_id)) { // Can specify a different author for a post than Auth user
                $post->author_id = auth()->user()->id;
            }
            if (empty($post->topic_id)) {
                throw new \Exception('Blog post must be assigned to a topic.');
            }
        });

        static::saving(function ($post) {
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
     */
    public function getPathAttribute()
    {
        return "/blog/{$this->slug}";
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
            'https://res.cloudinary.com/tger/t_cover/'.$this->image->filename.'.jpg';
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
            'https://res.cloudinary.com/tger/t_coverplaceholder/'.$this->image->filename.'.jpg';
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function ogimage()
    {
        return $this->belongsTo(Image::class, 'ogimage_id');
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updater_id');
    }

    public function isPublished()
    {
        return $this->published_at->isPast();
    }
}
