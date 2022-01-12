<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;

class AnswerCommentsController extends Controller
{
    public function index(Answer $answer)
    {
        $comments = $answer->comments()->paginate(10);

        array_map(function ($item) {
            return $this->appendVotedAttribute($item);
        }, $comments->items());

        return $comments;
    }

    public function store(Answer $answer)
    {
        $this->validate(\request(), [
            'content' => 'required'
        ]);
        $comment = $answer->comment(\request('content'), auth()->user(),);
        return $comment->load('owner');
    }
}
