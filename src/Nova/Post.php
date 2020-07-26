<?php

namespace App\Nova;

use Benjaminhirsch\NovaSlugField\Slug;
use Benjaminhirsch\NovaSlugField\TextWithSlug;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Post extends Resource
{
    public static $model = \DrewRoberts\Blog\Post::class;

    public static $title = 'title';

    public static $search = [
        'id',
    ];

    public static $group = 'Website Blog';

    public function fieldsForIndex(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Slug')->sortable(),
            Text::make('Title')->sortable(),
            BelongsTo::make('Author', 'author', 'App\Nova\User')->sortable(),
            DateTime::make('Published', 'published_at')->format('YYYY-MM-DD')->sortable(),
        ];
    }

    public function fields(Request $request)
    {
        return [
            TextWithSlug::make('Title')->slug('slug'),
            Slug::make('Slug')->disableAutoUpdateWhenUpdating(),
            BelongsTo::make('Topic'),
            BelongsTo::make('Author', 'author', 'App\Nova\User'),
            DateTime::make('Published', 'published_at'),
            Markdown::make('Content')->help(
                '<a href="#">External Link</a>'
            )->stacked(),
            Textarea::make('Description'),
            Textarea::make('Open Graph Description', 'ogdescription')->nullable(),
            BelongsTo::make('Image')->nullable()->showCreateRelationButton(),
            BelongsTo::make('OG Image', 'ogimage', \DrewRoberts\Media\Image::class)->nullable()->showCreateRelationButton(),

            new Panel('Data Fields', $this->dataFields()),
        ];
    }

    protected function dataFields()
    {
        return [
            ID::make(),
            DateTime::make('Created At')->hideWhenCreating()->hideWhenUpdating(),
            BelongsTo::make('Updater By', 'updater', 'App\Nova\User')->hideWhenCreating()->hideWhenUpdating(),
            DateTime::make('Updated At')->hideWhenCreating()->hideWhenUpdating(),
        ];
    }

    public function cards(Request $request)
    {
        return [];
    }

    public function filters(Request $request)
    {
        return [];
    }

    public function lenses(Request $request)
    {
        return [];
    }

    public function actions(Request $request)
    {
        return [];
    }

    public function authorizedToForceDelete(Request $request)
    {
        return false;
    }
}
