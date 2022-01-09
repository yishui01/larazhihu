<?php

namespace App\Models;

use App\Models\Traits\VoteTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    use VoteTrait;

    public $guarded = ["id"];

    protected $appends = [
        'upVotesCount',
        'downVotesCount',
        'commentsCount',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isBest()
    {
        return $this->id == $this->question->best_answer_id;
    }

    public function getCommentsCountAttribute()
    {
        return $this->comments->count();
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commented');
    }

    public function comment($content, $user)
    {
        $this->comments()->create([
            'user_id' => $user->id,
            'content' => $content
        ]);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($reply) {
            $reply->question->increment('answers_count');
        });
        static::deleted(function ($reply) {
            $reply->question->decrement('answers_count');
        });
    }

}
