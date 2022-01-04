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

use App\Http\Controllers\CrowdSourcingProjectColorsController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\QuestionnaireAnswerAnnotationController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\QuestionnaireResponseController;

Route::middleware(['throttle:api-internal'])->group(function () {


});

Route::middleware(['throttle:api-internal'])->group(function () {



});
