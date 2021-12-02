<?php

namespace App\Http\Controllers;

use App\Models\Answer;

class BestAnswersController extends Controller
{
    public function store(Answer $answer)
    {
        $answer->question->update([
            'best_answer_id' => $answer->id
        ]);
        return back();
    }
}
