<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;

class AnswersController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function store($questionId)
    {
        $this->validate(request(), [
            'content' => 'required'
        ]);
        /** @var Question $question */
        $question = Question::published()->findOrFail($questionId);
        $question->answers()->create([
            "user_id" => auth()->id(),
            "content" => request("content"),
        ]);
        return back();
    }

    public function destroy(Answer $answer)
    {
        $this->authorize('delete', $answer);
        $answer->delete();
        return back();
    }
}
