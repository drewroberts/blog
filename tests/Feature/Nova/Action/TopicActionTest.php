<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Tests\Feature\Nova\Action;

use DrewRoberts\Blog\Models\Topic;
use DrewRoberts\Blog\Nova\Actions\PreviewTopic;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Authorization\Models\User;

class TopicActionTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function testPreviewTopic()
    {
        $topic = Topic::factory()->create();
        $url = config('app.url') .config('tipoff.web.uri_prefix') . $topic->first()->path;

        $this->actingAs(User::factory()->create()->assignRole('Admin'));

        $response = $this->withExceptionHandling()
            ->post('/nova-api/topics/action?action='.(new PreviewTopic())->uriKey(), [
                'resources' => implode(',', [$topic->id]),
            ]);

        $this->assertEquals(['openInNewTab' => $url], $response->original);
    }
}
