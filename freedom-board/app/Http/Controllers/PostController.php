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
    public function index(Request $request){
        $search = $request->input('search');
        $query = Post::with(['user', 'replies.user'])
            ->whereNull('parent_id');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('content', 'like', "%$search%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('username', 'like', "%$search%") ;
                  });
            });
        }
        $posts = $query->latest()->paginate(5)->withQueryString();
        return view('board.index', compact('posts', 'search'));
    }

    // store a newly created post or reply

    public function store(Request $request){
        $validated = $request->validate([
            'content' => 'required|string|max:2000',
            'parent_id' => 'nullable|exists:posts,id',
        ]);
        $post = $request->user()->posts()->create($validated);
        return back()->with('success', (isset($validated['parent_id']) && $validated['parent_id']) ? 'Reply posted!' : 'Post success');
    }

    // remove specific post from db
    public function remove(Post $post){
        // TODO: still has to set up Policy for this Gate
        Gate::authorize('delete', $post);
        // delete post and its replies
        $post->replies()->delete();
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
