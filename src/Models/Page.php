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

class Page extends BaseModel
{
    use SoftDeletes, HasCreator, HasUpdater, HasPackageFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($page) {
            if (empty($page->author_id)) { // Can specify a different author for a page than Auth user
                $page->author_id = auth()->user()->id;
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\UrlGenerator|string
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getPlaceholderPathAttribute()
    {
        return $this->image === null ?
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
        return $this->belongsTo(app('video'));
    }

    public function isPublished()
    {
        return $this->published_at->isPast();
    }

    public function setParent(Page $parent)
    {
        $this->update(['parent_id' => $parent->id]);
    }
}
