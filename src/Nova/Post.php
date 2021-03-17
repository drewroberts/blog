<?php

namespace DrewRoberts\Blog\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Support\Nova\BaseResource;

class Post extends BaseResource
{
    public static $model = \DrewRoberts\Blog\Models\Post::class;

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
            BelongsTo::make('Series'),
            BelongsTo::make('Author', 'author', nova('user'))->sortable(),
            DateTime::make('Published', 'published_at')->format('YYYY-MM-DD')->sortable(),
        ];
    }

    public function fields(Request $request)
    {
        return [
            Text::make('Title')->required(),
            Slug::make('Slug')->from('Title'),
            DateTime::make('Published', 'published_at'),
            Markdown::make('Content')->help(
                '<a href="https://www.markdownguide.org">MarkdownGuide.org</a>'
            )->stacked(),

            new Panel('Sorting Fields', $this->sortFields()),
            new Panel('Info Fields', $this->infoFields()),
            new Panel('Data Fields', $this->dataFields()),
        ];
    }

    protected function sortFields()
    {
        return [
            BelongsTo::make('Topic')->exceptOnForms(),
            BelongsTo::make('Series')->nullable(),
        ];
    }

    protected function infoFields()
    {
        return [
            BelongsTo::make('Author', 'author', app('nova.user'))->nullable(),
            Textarea::make('Description'),
            Textarea::make('Open Graph Description', 'ogdescription')->nullable(),
            BelongsTo::make('Image', 'image', \DrewRoberts\Media\Nova\Image::class)->nullable()->showCreateRelationButton(),
            BelongsTo::make('OG Image', 'ogimage', \DrewRoberts\Media\Nova\Image::class)->nullable()->showCreateRelationButton(),
            BelongsTo::make('Video', 'video', \DrewRoberts\Media\Nova\Video::class)->nullable()->showCreateRelationButton(),
        ];
    }

    protected function dataFields(): array
    {
        return array_merge(
            parent::dataFields(),
            $this->creatorDataFields(),
            $this->updaterDataFields(),
        );
    }
}
