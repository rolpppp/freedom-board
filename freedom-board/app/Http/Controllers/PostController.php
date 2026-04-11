<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        // only fetch posts with no parent id (meaning, main post)
        $posts = Post::with(['user', 'replies.user'])
            ->whereNull('parent_id')
            ->latest()
            ->paginate(5);

        return view('board.index', compact('posts'));
    }

    // store a newly created post or reply
    public function store(){
        $validated = $request->validate([
            'content' => 'required|string|max:2000',
            'parent_id' => 'nullable|exists:posts,id',
        ]);

        // create a post to attach to a logged-in user
        $request->user()->post()->create($validated);

        return back()->with('success', 'Post success');
    }

    // remove specific post from db
    public function remove(){

        // TODO: still has to set up Policy for this Gate
        Gate::authorize('delete', $post);

        // delete post
        $post->delete();

        return back()->with('success', 'Post deleted successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
