<?php

namespace App\Models;

use App\Models\Traits\VoteTrait;
use App\Notifications\QuestionWasUpdated;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    use VoteTrait;

    protected $guarded = ['id'];

    protected $appends = [
        'upVotesCount',
        'downVotesCount',
        'subscriptionsCount'
    ];

    public function getSubscriptionsCountAttribute()
    {
        return $this->subscriptions()->count();
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function path()
    {
        return $this->slug ? "/questions/{$this->category->slug}/{$this->id}/{$this->slug}" : "/questions/{$this->category->slug}/{$this->id}";
    }

    public function addAnswer($answer)
    {
        $answer = $this->answers()->create($answer);
        $this->subscriptions()->where('user_id', '!=', $answer->user_id)
            ->each(function ($item) use ($answer) {
                $item->notify($answer);
            });
        return $answer;
    }

    public function isSubscribedTo($userId)
    {
        if (!$userId) {
            return false;
        }
        return Subscription::where(['user_id' => $userId, 'question_id' => $this->id])->exists();
    }

    public function subscribe($userId)
    {
        $this->subscriptions()->create(['user_id' => $userId]);
    }

    public function unsubscribe($userId)
    {
        $this->subscriptions()->where('user_id', $userId)->delete();
    }

    public function markAsBestAnswer($answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    public function scopeDrafts($query, $userId)
    {
        return $query->where(['user_id' => $userId])->whereNull('published_at');
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }


    public function publish()
    {
        $this->update([
            'published_at' => Carbon::now()
        ]);
    }

    public function invitedUsers()
    {
        preg_match_all('/@([^\s.]+)/', $this->content, $matches);
        return $matches[1];
    }

}
