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
            // Can specify a different author for a page than Auth user
            if (empty($page->author_id)) {
                $page->author_id = auth()->user()->id;
            }
        });

        static::deleting(function ($page) {
            if (count($page->children) > 0) {
                throw new \Exception("cannot delete a page having a children");
            }
        });
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
        return $this->hasOne(app('market'));
    }

    public function location()
    {
        return $this->hasOne(app('location'));
    }

    public function parent()
    {
        return $this->belongsTo(app('page'), 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(app('page'), 'parent_id');
    }


    public function setParent(Page $parent)
    {
        $this->parent_id = $parent->id;
        $this->save();
    }
}
