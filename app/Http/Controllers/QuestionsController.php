<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('must-verify-email')->except(['index', 'show']);
    }

    public function index()
    {

    }

    public function store()
    {
        $this->validate(\request(), [
            'title'       => 'required',
            'content'     => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);
        $question = Question::create([
            'user_id'     => Auth::id(),
            'category_id' => request('category_id'),
            'title'       => request('title'),
            'content'     => request('content')
        ]);

        return redirect("/questions/{$question->id}")->with('flash', "创建成功！");
    }

    public function show($questionId)
    {
        /** @var Question $question */
        $question = Question::published()->findOrFail($questionId);
        $answers = $question->answers()->paginate(20);
        array_map(function ($item) {
            return $this->appendVotedAttribute($item);
        }, $answers->items());
        return view("questions.show", [
            "question" => $question,
            "answers"  => $answers
        ]);
    }
}
