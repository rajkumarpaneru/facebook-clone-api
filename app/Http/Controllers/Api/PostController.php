<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
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
        $response = PostResource::make($post);
        return response($response, 201);
    }
}
