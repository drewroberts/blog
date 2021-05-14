<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Tests\Feature\Nova\Action;

use DrewRoberts\Blog\Models\Page;
use DrewRoberts\Blog\Nova\Actions\PreviewPage;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Authorization\Models\User;

class PageActionTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function testPreviewPage()
    {
        $page = Page::factory()->create();
        $url = config('app.url') . "/".config('tipoff.web.uri_prefix') . $page->first()->path;

        $this->actingAs(User::factory()->create()->assignRole('Admin'));

        $response = $this->withExceptionHandling()
            ->post('/nova-api/pages/action?action='.(new PreviewPage)->uriKey(), [
                'resources' => implode(',', [$page->id]),
            ]);

        $this->assertEquals(['openInNewTab' => $url], $response->original);
    }
}
