<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Gate;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PostController extends Controller implements  HasMiddleware
{
    /**
     * Display a listing of the resource.
     */
    public static function middleware(): array
{
    return [
       new Middleware ('auth:sanctum', ['except' => ['index', 'show']])
    ];
}

    public function index()
    {
        return Post::with('user')->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required|max:255',
            'body' =>  'required'
        ]);
        // $post =Post::create($validate);

        $post = $request->user()->posts()->create($validate);

        return $post;
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return $post;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('modify', $post);
        $validate = $request->validate([
            'title' => 'required|max:255',
            'body' =>   'required'
        ]);
        $post->update($validate);

        return $post;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('modify', $post);

        $post->delete();

        return ['massage'=> 'Post was deleted'];
    }
}
