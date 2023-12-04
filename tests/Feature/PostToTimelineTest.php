<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostToTimelineTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_post_a_text_post()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();

        $this->actingAs($user, 'api');

        $response = $this->post('/api/posts', [
            'data' => [
                'type' => 'posts',
                'attributes' => [
                    'body' => 'New Post',
                ]
            ]
        ]);

        $post = Post::first();
        $this->assertCount(1, Post::all());
        $this->assertEquals($user->id, $post->user_id);
        $this->assertEquals('New Post', $post->body);
        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'type' => 'posts',
                    'id' => $post->id,
                    'attributes' => [
                        'posted_by' => [
                            'data' => [
                                'attributes' => [
                                    'name' => $user->name,
                                ]
                            ]
                        ],
                        'body' => 'New Post'
                    ]
                ],
                'links' => [
                    'self' => url('/posts/' . $post->id)
                ]
            ]);
    }
}
