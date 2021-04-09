<?php

namespace DrewRoberts\Blog\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Support\Nova\BaseResource;

class Layout extends BaseResource
{
    public static $model = \DrewRoberts\Blog\Models\Layout::class;

    public static $title = 'name';

    public static $search = [
        'id',
        'name',
    ];

    public static $group = 'Website Content';

    public function fieldsForIndex(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Name')->sortable()->required(),
            Text::make('Layout Type')->sortable()->required(),
            Text::make('View')->sortable()->required(),
            nova('page') ? HasMany::make('Pages') : null,
            nova('post') ? HasMany::make('Posts') : null,
            nova('user') ? BelongsTo::make('Author', 'author', nova('user'))->sortable() : null,
        ];
    }

    public function fields(Request $request)
    {
        return [
            Text::make('Name')->sortable()->required(),
            Text::make('Layout Type')->sortable()->required(),
            Text::make('View')->sortable()->required(),
            Text::make('Note')->sortable()->nullable(),

            new Panel('Info Fields', $this->infoFields()),
            new Panel('Data Fields', $this->dataFields()),
        ];
    }

    protected function infoFields()
    {
        return [
            nova('user') ? BelongsTo::make('Author', 'author', nova('user'))->sortable() : null,
            nova('image') ? BelongsTo::make('Image', 'image', nova('image'))->nullable()->showCreateRelationButton() : null,
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
