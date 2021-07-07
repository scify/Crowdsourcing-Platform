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

use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\QuestionnaireResponseController;

Route::middleware(['auth:sanctum', 'throttle:api-internal'])->group(function () {
    Route::post('/questionnaire/new', [QuestionnaireController::class, 'store'])->name('store-questionnaire');
    Route::post('/questionnaire/update/{id?}', [QuestionnaireController::class, 'update'])->name('update-questionnaire');
    Route::post('/questionnaire/respond', [QuestionnaireResponseController::class, 'store'])->name('respond-questionnaire');
});
