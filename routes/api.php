<?php

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

Route::middleware(['auth:sanctum', 'throttle:api-internal'])->group(function () {
    Route::post('/questionnaire/new', 'QuestionnaireController@storeQuestionnaire')->name('store-questionnaire');
    Route::post('/questionnaire/update/{id?}', 'QuestionnaireController@updateQuestionnaire')->name('update-questionnaire');
    Route::post('/questionnaire/respond', 'QuestionnaireResponseController@storeQuestionnaireResponse')->name('respond-questionnaire');
});
