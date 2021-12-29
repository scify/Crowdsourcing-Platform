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

Route::middleware(['auth:sanctum', 'throttle:api-internal'])->group(function () {
    Route::post('/questionnaire/new', [QuestionnaireController::class, 'store'])->name('store-questionnaire');
    Route::post('/questionnaire/update/{id?}', [QuestionnaireController::class, 'update'])->name('update-questionnaire');


    Route::post('/questionnaire/translate', [QuestionnaireController::class, 'translateQuestionnaire'])->name('questionnaire.translate')->middleware("can:manage-crowd-sourcing-projects");
    Route::get('/questionnaire/languages', [QuestionnaireController::class, 'getLanguagesForQuestionnaire'])->name('questionnaire.languages');
    Route::post('/questionnaire/mark-translations', [QuestionnaireController::class, 'markQuestionnaireTranslations'])->name('questionnaire.mark-translations');
    Route::get('/languages', [LanguageController::class, 'getLanguages'])
        ->name('languages.get');
    Route::post('/questionnaire/answer-votes', [QuestionnaireResponseController::class, 'voteAnswer'])->name('questionnaire.answer-votes.create');
    Route::post('/questionnaire/answer-annotations', [QuestionnaireAnswerAnnotationController::class, 'annotateAnswer'])->name('questionnaire.answer-annotations.create');
    Route::post('/questionnaire/answer-annotations/delete', [QuestionnaireAnswerAnnotationController::class, 'deleteAnswerAnnotation'])->name('questionnaire.answer-annotations.delete');
});

Route::middleware(['throttle:api-internal'])->group(function () {
    //TODO: Discuss with the team.
    // a) Do we need throttling here? There are requests the users do not the app.
    // So if we use one single beared for all of this calls then what happens if we have many users making calls?
    // b) Maybe we should only use api.php for mobile apps.
    // Additionaly here we have a problem with the locales.
    // Some notifications are initated by the UI (there the locale is set by app()->locale) automatically inside the Notifications
    // But this breaks if the notifications are initiated by api.php actions.
    // So for example QuestionnaresResponded.php is initiated by the action below
    // for this reason we need to pass the locale in the  QuestionnaresResponded.php notification.
    // But this is not the same for the UserRegistered notification that is initiated at web.php. So we end up having
    // incosistencies in the code (Some notifications constructors require locale, other's don't, without beeing easy to undestand why)
    Route::post('/questionnaire/respond', [QuestionnaireResponseController::class, 'store'])->name('respond-questionnaire');
    Route::get('/crowd-sourcing-projects/colors/{id}', [CrowdSourcingProjectColorsController::class, 'getColorsForCrowdSourcingProjectOrDefault'])
        ->name('crowd-sourcing-project.get-colors');
    Route::get('/questionnaire/responses-get/{id}', [QuestionnaireResponseController::class, 'getResponsesForQuestionnaire'])
        ->name('questionnaire.responses');
    Route::get('/questionnaire/answer-votes-get/{id}', [QuestionnaireResponseController::class, 'getAnswerVotesForQuestionnaireAnswers'])
        ->name('questionnaire.answer-votes');
    Route::get('/questionnaire/answer-annotations-get/{id}', [QuestionnaireAnswerAnnotationController::class, 'getAnswerAnnotationsForQuestionnaireAnswers'])
        ->name('questionnaire.answer-annotations');
    Route::get('/questionnaire/answers-admin-analysis-statuses-get/', [QuestionnaireAnswerAnnotationController::class, 'getQuestionnaireAnswerAdminReviewStatuses'])
        ->name('questionnaire.answers-admin-analysis-statuses.get');
});
