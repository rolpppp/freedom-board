<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Post extends Model
{
    // we put the content since it is the only thing we
    // put inside the database
    protected $fillable = [
        'user_id',
        'content',
        'parent_id',
    ];

    // every post belongs to a user
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    // a post can have many replies
    public function replies(): HasMany{
        return $this->hasMany(Post::class, 'parent_id');
    }

    // a reply belongs to a post
    public function parent(): BelongsTo{
        return $this->belongsTo(Post::class, 'parent_id');
    }

}
