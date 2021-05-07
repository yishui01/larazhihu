<?php

namespace App\Http\Controllers;

use App\Models\Question;

class AnswersController extends Controller
{
    public function store(Question $question)
    {
        $question->answers()->create([
            "user_id" => request("user_id"),
            "content" => request("content"),
            "question_id" => request("question_id"),
        ]);
        return response()->json([], 201);
    }
}
