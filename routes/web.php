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

Auth::routes();

Route::get("/questions", "QuestionsController@index");
Route::get("/questions/{question}", "QuestionsController@show");
Route::middleware('auth')->group(function () {
    Route::post("/questions", "QuestionsController@store")->name('questions.store');
    Route::post('/questions/{question}/answers', 'AnswersController@store');
    Route::post('/answers/{answer}/best', 'BestAnswersController@store')->name('best-answers.store');
    Route::delete('/answers/{answer}', 'AnswersController@destroy')->name('answers.destroy');
    Route::post('/answers/{answer}/up-votes', 'AnswerUpVotesController@store')->name('answer-up-votes.store');
    Route::post('/answers/{answer}/cancel-up-votes', 'AnswerUpVotesController@destroy')->name('answer-up-votes.destroy');
    Route::post('/answers/{answer}/down-votes', 'AnswerDownVotesController@store')->name('answer-down-votes.store');
    Route::post('/answers/{answer}/cancel-down-votes', 'AnswerDownVotesController@destroy')->name('answer-down-votes.destroy');
});
