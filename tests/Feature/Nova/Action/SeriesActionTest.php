<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Tests\Feature\Nova\Action;

use DrewRoberts\Blog\Models\Series;
use DrewRoberts\Blog\Nova\Actions\PreviewSeries;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Authorization\Models\User;

class SeriesActionTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function testPreviewSeries()
    {
        $series = Series::factory()->create();

        $url = config('app.url') .config('tipoff.web.uri_prefix') . $series->first()->path;

        $this->actingAs(User::factory()->create()->assignRole('Admin'));

        $response = $this->withExceptionHandling()
            ->post('/nova-api/series/action?action='.(new PreviewSeries())->uriKey(), [
                'resources' => implode(',', [$series->id]),
            ]);

        $this->assertEquals(['openInNewTab' => $url], $response->original);
    }
}
