<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('must-verify-email')->except(['index', 'show']);
    }

    public function index(Category $category)
    {
        if ($category->exists) {
            $questions = Question::published()->where('category_id', $category->id);
        } else {
            $questions = Question::published();
        }
        if ($username = request('by')) {
            $user = User::whereName($username)->first();
            if ($user) {
                $questions->where('user_id', $user->id);
            }
        }
        $questions = $questions->paginate(20);
        return view('questions.index', [
            'questions' => $questions
        ]);
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

        return redirect("/drafts")->with('flash', "创建成功！");
    }

    public function create(Question $question)
    {
        $categories = Category::all();

        return view('questions.create', [
            'question'   => $question,
            'categories' => $categories
        ]);
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
