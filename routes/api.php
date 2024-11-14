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


use App\Http\Controllers\CrowdSourcingProject\CrowdSourcingProjectColorsController;
use App\Http\Controllers\CrowdSourcingProject\CrowdSourcingProjectController;
use App\Http\Controllers\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Questionnaire\QuestionnaireAnswerAnnotationController;
use App\Http\Controllers\Questionnaire\QuestionnaireController;
use App\Http\Controllers\Questionnaire\QuestionnaireReportController;
use App\Http\Controllers\Questionnaire\QuestionnaireResponseController;
use App\Http\Controllers\UserController;

Route::middleware(['throttle:api-public'])->group(function () {
    Route::get('/questionnaire/languages', [QuestionnaireController::class, 'getLanguagesForQuestionnaire'])->name('api.questionnaire.languages.get');
    Route::get('/languages', [LanguageController::class, 'getLanguages'])->name('api.languages.get');
    Route::post('/questionnaire/respond', [QuestionnaireResponseController::class, 'store'])->name('api.questionnaire-responses.store');
    Route::get('/questionnaire/response-anonymous', [QuestionnaireResponseController::class, 'getAnonymousUserResponseForQuestionnaire'])->name('api.questionnaire.anonymous-responses.get');
    Route::get('/crowd-sourcing-projects/colors/{id}', [CrowdSourcingProjectColorsController::class, 'getColorsForCrowdSourcingProjectOrDefault'])->name('api.crowd-sourcing-project.colors.get');
    Route::get('/questionnaire/responses-get/{id}/{projectFilter?}', [QuestionnaireResponseController::class, 'getResponsesForQuestionnaire'])->name('api.questionnaire.responses.get');
    Route::get('/questionnaire/answer-votes-get/{id}', [QuestionnaireResponseController::class, 'getAnswerVotesForQuestionnaireAnswers'])->name('api.questionnaire.answer-votes.get');
    Route::get('/questionnaire/answer-annotations-get/{id}', [QuestionnaireAnswerAnnotationController::class, 'getAnswerAnnotationsForQuestionnaireAnswers'])->name('api.questionnaire.answer-annotations.get');
    Route::post('/files/upload', [FileController::class, 'uploadFiles'])->name('api.files.upload');
});

Route::middleware(['throttle:api-internal', 'auth'])->group(function () {
    Route::post('/questionnaire/answer-votes', [QuestionnaireResponseController::class, 'voteAnswer'])->name('api.questionnaire.answer-votes.store');
});

Route::group(['middleware' => ['throttle:api-internal', 'auth', 'can:moderate-content-by-users']], function () {
    Route::get('questionnaire/report-data', [QuestionnaireReportController::class, 'getReportDataForQuestionnaire'])->name('api.questionnaire.report-data.get');
    Route::post('/questionnaire/answer-annotations', [QuestionnaireAnswerAnnotationController::class, 'annotateAnswer'])->name('api.questionnaire.answer-annotations.store');
    Route::post('/questionnaire/answer-annotations/delete', [QuestionnaireAnswerAnnotationController::class, 'deleteAnswerAnnotation'])->name('questionnaire.answer-annotations.destroy');
    Route::get('/questionnaire/answers-admin-analysis-statuses-get/', [QuestionnaireAnswerAnnotationController::class, 'getQuestionnaireAnswerAdminReviewStatuses'])->name('questionnaire.answers-admin-analysis-statuses.get');
    Route::post('questionnaire/delete-response', [QuestionnaireResponseController::class, 'destroy'])->name('questionnaire_response.destroy');
});

Route::group(['middleware' => ['throttle:api-internal', 'auth', 'can:manage-platform-content']], function () {
    Route::post('/questionnaire/new', [QuestionnaireController::class, 'store'])->name('api.questionnaire.store');
    Route::post('/questionnaire/update/{id?}', [QuestionnaireController::class, 'update'])->name('api.questionnaire.update');
    Route::post('/questionnaire/translate', [QuestionnaireController::class, 'translateQuestionnaire'])->name('api.questionnaire.translation.store');
    Route::post('/questionnaire/mark-translations', [QuestionnaireController::class, 'markQuestionnaireTranslations'])->name('api.questionnaire.translations.mark');
    Route::get('/crowd-sourcing-projects/for-problems', [CrowdSourcingProjectController::class, 'getCrowdSourcingProjectsForProblems'])->name('api.crowd-sourcing-projects.for-problems.get');
    Route::post('/crowd-sourcing-projects/get-problems-for-management', [CrowdSourcingProjectProblemController::class, 'getProblemsForCrowdSourcingProjectForManagement'])->name('api.crowd-sourcing-projects.problems.get-management');
    Route::get('/problems/statuses/management', [CrowdSourcingProjectProblemController::class, 'getProblemStatusesForManagementPage'])->name('api.problems.statuses.management.get');
});

Route::group(['middleware' => ['throttle:api-internal', 'auth', 'can:manage-users']], function () {
    Route::get('/users/filter', [UserController::class, 'showUsersByCriteria'])->name('api.users.get-filtered');
});
