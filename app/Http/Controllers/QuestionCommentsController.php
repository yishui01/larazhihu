<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionCommentsController extends Controller
{

    public function index(Question $question)
    {
        $comments = $question->comments()->paginate(10);
        array_map(function ($item) {
            return $this->appendVotedAttribute($item);
        }, $comments->items());
        return $comments;
    }

    public function store($questionId)
    {
        $this->validate(request(), [
            'content' => 'required'
        ]);
        /** @var Question $question */
        $question = Question::published()->findOrFail($questionId);
        $comment = $question->comment(request('content'), auth()->user());
        return $comment->load('owner');
    }
}
