<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class SubscribeQuestionsController extends Controller
{
    public function store(Question $question)
    {
        $question->subscribe(auth()->id());
        return response([], 201);
    }

    public function destroy(Question $question)
    {
        $question->unsubscribe(auth()->id());
        return response([], 201);
    }
}
