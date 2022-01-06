<?php

namespace App\Models;

use App\Models\Traits\VoteTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    use VoteTrait;

    protected $guarded = ['id'];

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

    public function addAnswer($answer)
    {
        return $this->answers()->create($answer);
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
