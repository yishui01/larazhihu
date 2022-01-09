<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionCommentsController extends Controller
{
    public function store($questionId)
    {
        $this->validate(request(), [
            'content' => 'required'
        ]);
        /** @var Question $question */
        $question = Question::published()->findOrFail($questionId);
        $comment = $question->comments()->create([
            'user_id' => auth()->id(),
            'content' => request('content')
        ]);

        return back();
    }
}
