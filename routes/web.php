<?php

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

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\CrowdSourcingProjectColorsController;
use App\Http\Controllers\CrowdSourcingProjectController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\QuestionnaireAnswerAnnotationController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\QuestionnaireReportController;
use App\Http\Controllers\QuestionnaireResponseController;
use App\Http\Controllers\QuestionnaireStatisticsController;
use App\Http\Controllers\UserController;
use App\Models\User;
use App\Notifications\UserRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(app()->getLocale());
});

$regexForLocalParameter = config('app.regex_for_validating_locale_at_routes');
$localeInfo = ['prefix' => '{locale}',
    'where' => ['locale' => $regexForLocalParameter],
    'middleware' => 'setlocale',
];
Route::group($localeInfo, function () {
    Auth::routes();
    Route::get('/', [HomeController::class, 'showHomePage'])->name('home');
    Route::get('/terms-and-privacy', [HomeController::class, 'showTermsAndPrivacyPage'])->name('terms.privacy');
    Route::get('/code-of-conduct', [HomeController::class, 'showCodeOfConductPage'])->name('codeOfConduct');
});

Route::get('/terms-and-privacy', function () {
    return redirect(app()->getLocale() . '/terms-and-privacy');
});
Route::get('/code-of-conduct', function () {
    return redirect(app()->getLocale() . '/code-of-conduct');
});

Route::post('/files/upload', [FileController::class, 'uploadFiles'])->name('files.upload');

Route::get('login/social/{driver}', [LoginController::class, 'redirectToProvider']);
Route::get('login/social/{driver}/callback', [LoginController::class, 'handleProviderCallback'])->name('socialLoginCallback');

Route::post('/newsletter', [CommunicationController::class, 'signUpForNewsletter'])->name('newsletter');

Route::group(['prefix' => '{locale}',
    'where' => ['locale' => $regexForLocalParameter],
    'middleware' => ['auth', 'setlocale'],
], function () {
    Route::get('/my-dashboard', [UserController::class, 'myDashboard'])->name('my-dashboard');
    Route::get('/my-account', [UserController::class, 'myAccount'])->name('my-account');
    Route::get('/users/history', [UserController::class, 'showUserHistory'])->name('myHistory');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/admin/manage-users', [AdminController::class, 'manageUsers'])->name('manage-users')->middleware('can:manage-users');
    Route::get('/admin/edit-user/{id}', [AdminController::class, 'EditUserForm'])->name('edit-user')->middleware('can:manage-users');
    Route::post('/admin/add-user', [AdminController::class, 'addUserToPlatform'])->middleware('can:manage-users');
    Route::post('admin/update-user', [AdminController::class, 'updateUserRoles'])->middleware('can:manage-platform');
    Route::post('/user/update', [UserController::class, 'patch'])->name('updateUser');
    Route::post('/user/delete', [UserController::class, 'delete'])->name('deleteUser')->middleware('can:manage-users');
    Route::post('/user/deactivate', [UserController::class, 'deactivateLoggedInUser'])->name('deactivateUser');
    Route::post('/user/restore', [UserController::class, 'restore'])->name('restoreUser')->middleware('can:manage-users');
    Route::get('/users/filter', [UserController::class, 'showUsersByCriteria'])->name('filterUsers')->middleware('can:manage-users');

    Route::get('/users/data/download', [UserController::class, 'downloadUserData'])->name('downloadMyData');
    Route::resource('projects', CrowdSourcingProjectController::class)->except([
        'destroy',
    ])->middleware('can:manage-crowd-sourcing-projects');
    Route::get('project/{id}/clone', [CrowdSourcingProjectController::class, 'clone'])->name('project.clone')->middleware('can:manage-crowd-sourcing-projects');
    Route::post('project/destroy', [CrowdSourcingProjectController::class, 'destroy'])->name('project.destroy')->middleware('can:manage-crowd-sourcing-projects');

    Route::get('/questionnaires', [QuestionnaireController::class, 'manageQuestionnaires'])->name('questionnaires.all')->middleware('can:manage-crowd-sourcing-projects');

    Route::get('/questionnaires/reports', [QuestionnaireReportController::class, 'viewReportsPage'])
        ->name('questionnaires.reports')->middleware('can:moderate-results');

    Route::get('questionnaire/report-data', [QuestionnaireReportController::class, 'getReportDataForQuestionnaire'])->name('questionnaire.get-report-data');

    Route::get('/questionnaire/new', [QuestionnaireController::class, 'createQuestionnaire'])->name('create-questionnaire')->middleware('can:manage-crowd-sourcing-projects');

    Route::get('/questionnaire/{id}/edit', [QuestionnaireController::class, 'editQuestionnaire'])->name('edit-questionnaire')->middleware('can:manage-crowd-sourcing-projects');
    Route::post('/questionnaire/update-status', [QuestionnaireController::class, 'saveQuestionnaireStatus'])->name('update-questionnaire-status')->middleware('can:manage-crowd-sourcing-projects');
    Route::get('/questionnaires/{questionnaire}/colors', [QuestionnaireStatisticsController::class, 'showEditStatisticsColorsPage'])->name('statistics-colors-page')->middleware('can:manage-crowd-sourcing-projects');
    Route::post('/questionnaires/{questionnaire}/colors', [QuestionnaireStatisticsController::class, 'saveStatisticsColors'])->name('statistics-colors')->middleware('can:manage-crowd-sourcing-projects');
    Route::post('questionnaire/delete-response', [QuestionnaireResponseController::class, 'destroy'])->name('questionnaire_response.destroy');
    Route::get('/questionnaire/{questionnaire_id}/download-responses', [QuestionnaireResponseController::class, 'downloadQuestionnaireResponses'])
        ->name('questionnaire.responses.download');

    Route::get('/communication/mailchimp', [CommunicationController::class, 'getMailChimpIntegration'])->name('mailchimp-integration.get')->middleware('can:manage-platform');
    Route::post('/communication/mailchimp', [CommunicationController::class, 'storeMailChimpListsIds'])->name('mailchimp-integration')->middleware('can:manage-platform');
});


Route::group($localeInfo, function () {
    Route::get('/questionnaires/{questionnaire}/statistics/{projectFilter?}',
        [QuestionnaireStatisticsController::class, 'showStatisticsPageForQuestionnaire'])
        ->name('questionnaire.statistics')
        ->middleware('questionnaire.page_settings');
});


Route::group(['middleware' => 'auth'], function () {
    Route::get('/test-sentry/{message}', function (Request $request) {
        throw new Exception('Test Sentry error: ' . $request->message);
    })->middleware('can:manage-platform');

    Route::get('/phpinfo', function (Request $request) {
        phpinfo();
    })->middleware('can:manage-platform');

    Route::get('/test-email/{email}', function (Request $request) {
        User::where(['email' => $request->email])->first()->notify(new UserRegistered());

        return 'Success! Email sent to: ' . $request->email;
    })->middleware('can:manage-platform');
});

Route::post('/questionnaire/new', [QuestionnaireController::class, 'store'])->name('store-questionnaire');
Route::post('/questionnaire/update/{id?}', [QuestionnaireController::class, 'update'])->name('update-questionnaire');
Route::post('/questionnaire/translate', [QuestionnaireController::class, 'translateQuestionnaire'])->name('questionnaire.translate')->middleware('can:manage-crowd-sourcing-projects');
Route::get('/questionnaire/languages', [QuestionnaireController::class, 'getLanguagesForQuestionnaire'])->name('questionnaire.languages');
Route::post('/questionnaire/mark-translations', [QuestionnaireController::class, 'markQuestionnaireTranslations'])->name('questionnaire.mark-translations');
Route::get('/languages', [LanguageController::class, 'getLanguages'])->name('languages.get');
Route::post('/questionnaire/answer-votes', [QuestionnaireResponseController::class, 'voteAnswer'])->name('questionnaire.answer-votes.create');
Route::post('/questionnaire/answer-annotations', [QuestionnaireAnswerAnnotationController::class, 'annotateAnswer'])->name('questionnaire.answer-annotations.create');
Route::post('/questionnaire/answer-annotations/delete', [QuestionnaireAnswerAnnotationController::class, 'deleteAnswerAnnotation'])->name('questionnaire.answer-annotations.delete');

Route::post('/questionnaire/respond', [QuestionnaireResponseController::class, 'store'])->name('respond-questionnaire');
Route::get('/questionnaire/response-anonymous', [QuestionnaireResponseController::class, 'getAnonymousUserResponseForQuestionnaire'])->name('questionnaire.response-anonymous');
Route::get('/crowd-sourcing-projects/colors/{id}', [CrowdSourcingProjectColorsController::class, 'getColorsForCrowdSourcingProjectOrDefault'])
    ->name('crowd-sourcing-project.get-colors');
Route::get('/questionnaire/responses-get/{id}/{projectFilter?}', [QuestionnaireResponseController::class, 'getResponsesForQuestionnaire'])
    ->name('questionnaire.responses');
Route::get('/questionnaire/answer-votes-get/{id}', [QuestionnaireResponseController::class, 'getAnswerVotesForQuestionnaireAnswers'])
    ->name('questionnaire.answer-votes');
Route::get('/questionnaire/answer-annotations-get/{id}', [QuestionnaireAnswerAnnotationController::class, 'getAnswerAnnotationsForQuestionnaireAnswers'])
    ->name('questionnaire.answer-annotations');
Route::get('/questionnaire/answers-admin-analysis-statuses-get/', [QuestionnaireAnswerAnnotationController::class, 'getQuestionnaireAnswerAdminReviewStatuses'])
    ->name('questionnaire.answers-admin-analysis-statuses.get');

Route::group($localeInfo, function () {
    Route::get('/{project_slug}', [CrowdSourcingProjectController::class, 'showLandingPage'])->name('project.landing-page');
    Route::get('/{project_slug}/{questionnaire_id}/thanks', [QuestionnaireResponseController::class, 'showQuestionnaireThanksForRespondingPage'])->name('questionnaire.thanks');
});
