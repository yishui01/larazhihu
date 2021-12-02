<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    public $guarded = ["id"];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function isBest()
    {
        return $this->id == $this->question->best_answer_id;
    }
}
