<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get("/questions/{category?}", "QuestionsController@index");
Route::get('/questions/{question}/comments', 'QuestionCommentsController@index')->name('question-comments.index');
Route::get('/answers/{answer}/comments', 'AnswerCommentsController@index')->name('answer-comments.index');

Route::middleware('auth')->group(function () {
    Route::get('/drafts', 'DraftsController@index');
    Route::get('/questions/create', 'QuestionsController@create')->name('questions.create');
    Route::post("/questions", "QuestionsController@store")->name('questions.store');
    Route::post('/questions/{question}/answers', 'AnswersController@store');
    Route::post('/questions/{question}/published-questions', 'PublishedQuestionsController@store')->name('published-questions.store');
    Route::post('/questions/{question}/up-votes', 'QuestionUpVotesController@store')->name('question-up-votes.store');
    Route::post('/questions/{question}/cancel-up-votes', 'QuestionUpVotesController@destroy')->name('question-up-votes.destroy');
    Route::post('/questions/{question}/down-votes', 'QuestionDownVotesController@store')->name('question-down-votes.store');
    Route::post('/questions/{question}/cancel-down-votes', 'QuestionDownVotesController@destroy')->name('question-down-votes.destroy');
    Route::post('/questions/{question}/comments', 'QuestionCommentsController@store')->name('question-comments.store');
    Route::post('/answers/{answer}/comments', 'AnswerCommentsController@store')->name('answer-comments.store');
    Route::post('/answers/{answer}/best', 'BestAnswersController@store')->name('best-answers.store');
    Route::delete('/answers/{answer}', 'AnswersController@destroy')->name('answers.destroy');
    Route::post('/answers/{answer}/up-votes', 'AnswerUpVotesController@store')->name('answer-up-votes.store');
    Route::post('/answers/{answer}/cancel-up-votes', 'AnswerUpVotesController@destroy')->name('answer-up-votes.destroy');
    Route::post('/answers/{answer}/down-votes', 'AnswerDownVotesController@store')->name('answer-down-votes.store');
    Route::post('/answers/{answer}/cancel-down-votes', 'AnswerDownVotesController@destroy')->name('answer-down-votes.destroy');

    Route::post('/comments/{comment}/up-votes', 'CommentUpVotesController@store')->name('comment-up-votes.store');
    Route::post('/comments/{comment}/cancel-up-votes', 'CommentUpVotesController@destroy')->name('comment-up-votes.destroy');
    Route::post('/comments/{comment}/down-votes', 'CommentDownVotesController@store')->name('comment-down-votes.store');
    Route::post('/comments/{comment}/cancel-down-votes', 'CommentDownVotesController@destroy')->name('comment-down-votes.destroy');

    Route::post('/questions/{question}/subscriptions', 'SubscribeQuestionsController@store')->name('subscribe-questions.store');
    Route::delete('/questions/{question}/subscriptions', 'SubscribeQuestionsController@destroy')->name('subscribe-questions.destroy');
});
Route::get("/questions/{category}/{question}/{slug?}", "QuestionsController@show");

