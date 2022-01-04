<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\User;
use App\Notifications\YouWereInvited;
use App\Providers\PublishQuestion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublishedQuestionsController extends Controller
{
    public function store(Question $question)
    {
        $this->authorize('update', $question);
        $question->publish();
        event(new PublishQuestion($question));
        return redirect("/questions/{$question->id}")->with('flash', "发布成功！");
    }
}
