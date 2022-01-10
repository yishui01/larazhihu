<?php

namespace App\Models\Traits;

trait CommentTrait
{
    public function comment($content, $user)
    {
        return $this->comments()->create([
            'user_id' => $user->id,
            'content' => $content
        ]);
    }

    public function comments()
    {
        return $this->morphMany(\App\Models\Comment::class, 'commented');
    }

    public function getCommentsCountAttribute()
    {
        return $this->comments->count();
    }
}
