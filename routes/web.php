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

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['can:manage users'])->group(function() {
    Route::resource('users', 'UserController')
        ->except(['create', 'store']);
});

Route::resource('feedbacks', 'FeedbackController');
Route::resource('surveys', 'SurveyController');
Route::apiResource('surveys.questions', 'SurveyQuestionController')->shallow();
Route::get('surveys/{survey}/fill', 'SurveyResponseController@fill')->name('surveys.fill');
Route::post('surveys/{survey}/fill', 'SurveyResponseController@store');
Route::apiResource('questions.answers', 'SurveyQuestionAnswerController')->shallow();
Route::get('results/surveys', 'ResultsController@surveys')
    ->middleware('can:view survey results')
    ->name('results.surveys');
Route::apiResource('sensors', 'SensorController');
Route::apiResource('sensors.data', 'SensorDataController')->shallow();
Route::resource('rooms', 'RoomController')->only(['index', 'show']);
Route::apiResource('sensortypes', 'SensorTypeController')->only(['index']);
