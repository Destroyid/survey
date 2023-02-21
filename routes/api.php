<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function(){
    Route::get('admin/survey/all', 'AdminController@SurveyAll');

    Route::post('admin/survey/add', 'AdminController@SurveyAdd');
    Route::put('admin/survey/change/{change}', 'AdminController@SurveyChange');
    Route::delete('admin/survey/delete/{id}', 'AdminController@SurveyDelete');

    Route::post('admin/question/add/{id}', 'AdminController@QuestionAdd');
    Route::put('admin/question/change/{id}/{poll_id}', 'AdminController@QuestionChange');
    Route::delete('admin/question/delete/{id}/{q_id}', 'AdminController@QuestionDelete');

});

Route::get('user/list_survey', 'UserController@ListSurvey');
Route::get('user/get_passed_survey/{id}', 'UserController@GetPassedSurvey');
Route::post('user/answer/{id}', 'UserController@Answer');

Route::post('/login', 'Api\Auth\LoginController@login');