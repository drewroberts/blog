<?php

namespace DrewRoberts\Blog\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tipoff\Support\Traits\HasPackageFactory;

class Page extends Model
{
    use SoftDeletes;
    use HasPackageFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (auth()->check()) {
                $page->creator_id = auth()->id();
            }
        });

        static::saving(function ($page) {
            if (empty($page->author_id)) { // Can specify a different author for a page than Auth user
                $page->author_id = auth()->user()->id;
            }
            if (auth()->check()) {
                $page->updater_id = auth()->id();
            }
            if (empty($page->pageviews)) {
                $page->pageviews = 0;
            }
            if (empty($page->published_at)) {
                $page->published_at = Carbon::now();
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
     * Get a string path for the page image.
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
     * Get a string path for the page image's placeholder.
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

    public function parent()
    {
        return $this->belongsTo(app('page'), 'parent_id');
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
        return $this->belongsTo(app('video')::class);
    }

    public function creator()
    {
        return $this->belongsTo(app('user'), 'creator_id');
    }

    public function updater()
    {
        return $this->belongsTo(app('user'), 'updater_id');
    }

    public function isPublished()
    {
        return $this->published_at->isPast();
    }
}
