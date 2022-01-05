<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DraftsController extends Controller
{
    public function index()
    {
        $drafts = Question::drafts(Auth::id())->get();

        return view('drafts.index', [
            'drafts' => $drafts
        ]);
    }
}
