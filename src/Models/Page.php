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

class Page extends BaseModel
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

    protected $fillable = ['slug', 'title'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($page) {
            
            $page->author_id = 1; // @todo we can remove this line when the blog model is fixed
            $page->creator_id = 1; //@todo the page model has the trait, we can remove this when the blog is fixed
            $page->updater_id = 1; //@todo the page model has the trait, we can remove this when the blog is fixed

            // Can specify a different author for a page than Auth user
            if (empty($page->author_id)) {
                $page->author_id = auth()->user()->id;
            }
        });
    }

    public static function create($slug, $title)
    {
        $page = new Page;
        $page->slug = $slug;
        $page->title = $title;
        $page->save();

        return $page;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function author()
    {
        return $this->belongsTo(app('user'), 'author_id');
    }

    public function market()
    {
        return $this->belongsTo(app('market'));
    }

    public function parent()
    {
        return $this->belongsTo(app('page'), 'parent_id');
    }

    public function setParent(Page $parent)
    {
        $this->update(['parent_id' => $parent->id]);
    }
}
