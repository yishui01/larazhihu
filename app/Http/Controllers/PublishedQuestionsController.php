<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\User;
use App\Notifications\YouWereInvited;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublishedQuestionsController extends Controller
{
    public function store(Question $question)
    {
        $this->authorize('update', $question);
        preg_match_all('/@([^\s.]+)/',$question->content,$matches);
        if ($matches) {
            $names = $matches[1];
            foreach ($names as $name) {
                /** @var User $user */
                $user = User::whereName($name)->first();
                if ($user) {
                    $user->notify(new YouWereInvited($question));
                }
            }
        }
        $question->publish();
    }
}
