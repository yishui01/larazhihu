<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerDownVotesController extends Controller
{
    public function store(Answer $answer)
    {
        $answer->voteDown(Auth::user());
        return response([], 201);
    }
}
