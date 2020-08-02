<?php

namespace DrewRoberts\Blog\Nova;

use Benjaminhirsch\NovaSlugField\Slug;
use Benjaminhirsch\NovaSlugField\TextWithSlug;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Laravel\Nova\Resource;

class Topic extends Resource
{
    public static $model = \DrewRoberts\Blog\Topic::class;

    public static $title = 'title';

    public static $search = [
        'id',
        'title',
    ];

    public static $group = 'Website Blog';

    public function fieldsForIndex(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Slug')->sortable(),
            Text::make('Title')->sortable(),
            // @todo add count for Series
            // @todo add count for Posts
        ];
    }

    public function fields(Request $request)
    {
        return [
            TextWithSlug::make('Title')->slug('slug'),
            Slug::make('Slug')->disableAutoUpdateWhenUpdating(),
            Textarea::make('Note')->nullable(),

            new Panel('Content Fields', $this->contentFields()),

            HasMany::make('Series'),
            HasMany::make('Posts'),
            
            new Panel('Data Fields', $this->dataFields()),
        ];
    }

    protected function contentFields()
    {
        return [
            Markdown::make('Content')->help(
                '<a href="#">External Link</a>'
            )->stacked(),
            Textarea::make('Description'),
            Textarea::make('Open Graph Description', 'ogdescription')->nullable(),
            BelongsTo::make('Image')->nullable()->showCreateRelationButton(),
            BelongsTo::make('OG Image', 'ogimage', \DrewRoberts\Media\Image::class)->nullable()->showCreateRelationButton(),
            BelongsTo::make('Video')->nullable(),
        ];
    }

    protected function dataFields()
    {
        return [
            ID::make(),
            BelongsTo::make('Created By', 'updater', 'App\Nova\User')->hideWhenCreating()->hideWhenUpdating(),
            DateTime::make('Created At')->hideWhenCreating()->hideWhenUpdating(),
            BelongsTo::make('Updated By', 'updater', 'App\Nova\User')->hideWhenCreating()->hideWhenUpdating(),
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

    public function authorizedToDelete(Request $request)
    {
        return false;
    }

    public function authorizedToForceDelete(Request $request)
    {
        return false;
    }
}
