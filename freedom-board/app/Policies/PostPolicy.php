<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Anyone (even guests) can view the board.
     * Returning true here, but for guest support, the controller should not
     * call $this->authorize('viewAny', Post::class) — viewing should be public.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Anyone can view a single post.
     */
    public function view(User $user, Post $post): bool
    {
        return true;
    }

    /**
     * Any authenticated user can create posts.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Only the post's author can update it.
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    /**
     * Only the post's author can delete it.
     * This is the key authorization rule for your task.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    /**
     * Restore is not used in this app.
     */
    public function restore(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Permanent deletion is not used in this app.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }
}