<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'data.attributes.body' => '',
        ]);

        $post = $request->user()->posts()->create($validated['data']['attributes']);
        return response([
            'data' => [
                'type' => 'posts',
                'id' => $post->id,
                'attributes' => [
                    'body' => $post->body,
                ]
            ],
            'links' => [
                'self' => url('/posts/' . $post->id)
            ]
        ], 201);
    }
}
