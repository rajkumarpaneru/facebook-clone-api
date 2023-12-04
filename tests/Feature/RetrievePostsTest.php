<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RetrievePostsTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_user_can_retrieve_posts()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $posts = Post::factory()->count(2)->create();

        $response = $this->get('/api/posts');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'data' => [
                            'type' => 'posts',
                            'id' => $posts->first()->id,
                            'attributes' => [
                                'body' => $posts->first()->body,
                            ]
                        ]
                    ],
                    [
                        'data' => [
                            'type' => 'posts',
                            'id' => $posts->last()->id,
                            'attributes' => [
                                'body' => $posts->last()->body,
                            ]
                        ]
                    ]
                ],
                'links' => [
                    'self' => url('/posts'),
                ]
            ]);

    }
}
