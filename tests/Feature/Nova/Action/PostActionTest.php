<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Tests\Feature\Nova\Action;

use DrewRoberts\Blog\Models\Post;
use DrewRoberts\Blog\Nova\Actions\PreviewPost;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Authorization\Models\User;

class PostActionTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function testPreviewPost()
    {
        $post = Post::factory()->create();

        $url = config('app.url') . config('tipoff.web.uri_prefix') . $post->first()->path;

        $this->actingAs(User::factory()->create()->assignRole('Admin'));

        $response = $this->withExceptionHandling()
            ->post('/nova-api/posts/action?action='.(new PreviewPost())->uriKey(), [
                'resources' => implode(',', [$post->id]),
            ]);

        $this->assertEquals(['openInNewTab' => $url], $response->original);
    }
}
