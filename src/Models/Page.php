<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Models;

use DrewRoberts\Blog\Traits\Publishable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class Page extends BaseModel
{
    use SoftDeletes,
        HasCreator,
        HasUpdater,
        HasPackageFactory,
        Publishable;

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
        $cloudName = config('filesystem.disks.cloudinary.cloud_name');

        return $this->image === null ?
            url('img/ogimage.jpg') :
            "https://res.cloudinary.com/{$cloudName}/t_cover/{$this->image->filename}";
    }

    /**
     * Get a string path for the page image's placeholder.
     *
     * @return string
     */
    public function getPlaceholderPathAttribute()
    {
        $cloudName = config('filesystem.disks.cloudinary.cloud_name');

        return $this->image === null ?
            url('img/ogimage.jpg') :
            "https://res.cloudinary.com/{$cloudName}/t_coverplaceholder/{$this->image->filename}";
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

    public function setParent(Page $parent)
    {
        $this->update(['parent_id' => $parent->id]);
    }
}
