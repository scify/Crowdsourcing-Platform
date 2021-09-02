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
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\QuestionnaireResponseController;

Route::middleware(['auth:sanctum', 'throttle:api-internal'])->group(function () {
    Route::post('/questionnaire/new', [QuestionnaireController::class, 'store'])->name('store-questionnaire');
    Route::post('/questionnaire/update/{id?}', [QuestionnaireController::class, 'update'])->name('update-questionnaire');
    Route::post('/questionnaire/respond', [QuestionnaireResponseController::class, 'store'])->name('respond-questionnaire');
    Route::get('/questionnaire/responses/{id}', [QuestionnaireResponseController::class, 'getResponsesForQuestionnaire'])
        ->name('questionnaire.responses');
    Route::get('/crowd-sourcing-projects/colors/{id}', [CrowdSourcingProjectColorsController::class, 'getColorsForCrowdSourcingProjectOrDefault'])
        ->name('crowd-sourcing-project.get-colors');
    Route::get('/questionnaire/answer-votes/{id}', [QuestionnaireResponseController::class, 'getAnswerVotesForQuestionnaireAnswers'])
        ->name('questionnaire.answer-votes');
    Route::post('/questionnaire/answer-votes', [QuestionnaireResponseController::class, 'voteAnswer'])->name('questionnaire.answer-votes.vote');
    Route::post('/questionnaire/translate', [QuestionnaireController::class, 'translateQuestionnaire'])->name('questionnaire.translate')->middleware("can:manage-crowd-sourcing-projects");
    Route::get('/questionnaire/languages', [QuestionnaireController::class, 'getLanguagesForQuestionnaire'])->name('questionnaire.languages');
    Route::post('/questionnaire/mark-translations', [QuestionnaireController::class, 'markQuestionnaireTranslations'])->name('questionnaire.mark-translations');
});
