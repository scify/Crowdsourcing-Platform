<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\CrowdSourcingProject\CrowdSourcingProjectController;
use App\Http\Controllers\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Questionnaire\QuestionnaireController;
use App\Http\Controllers\Questionnaire\QuestionnaireReportController;
use App\Http\Controllers\Questionnaire\QuestionnaireResponseController;
use App\Http\Controllers\Questionnaire\QuestionnaireStatisticsController;
use App\Http\Controllers\UserController;
use App\Models\User;
use App\Notifications\UserRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect(app()->getLocale()));

$localeInfo = [
    'prefix' => '{locale}',
    'where' => ['locale' => config('app.regex_for_validating_locale_at_routes')],
    'middleware' => 'setlocale',
];

Route::group($localeInfo, function () {
    Auth::routes();
    Route::get('/', [HomeController::class, 'showHomePage'])->name('home');
    Route::get('/terms-and-privacy', [HomeController::class, 'showTermsAndPrivacyPage'])->name('terms.privacy');
    Route::get('/code-of-conduct', [HomeController::class, 'showCodeOfConductPage'])->name('codeOfConduct');
});

Route::get('/terms-and-privacy', fn () => redirect(app()->getLocale() . '/terms-and-privacy'));
Route::get('/code-of-conduct', fn () => redirect(app()->getLocale() . '/code-of-conduct'));

Route::get('login/social/{driver}', [LoginController::class, 'redirectToProvider']);
Route::get('login/social/{driver}/callback', [LoginController::class, 'handleProviderCallback'])->name('socialLoginCallback');

Route::group(['middleware' => ['auth', 'setlocale']], function () use ($localeInfo) {
    Route::group($localeInfo, function () {
        Route::get('/my-dashboard', [UserController::class, 'myDashboard'])->name('my-dashboard');
        Route::get('/my-account', [UserController::class, 'myAccount'])->name('my-account');
        Route::get('/my-contributions', [UserController::class, 'showUserContributions'])->name('my-contributions');
    });
});

Route::group(['middleware' => ['auth', 'can:manage-users']], function () {
    Route::get('/admin/manage-users', [AdminController::class, 'manageUsers'])->name('manage-users');
    Route::get('/admin/edit-user/{id}', [AdminController::class, 'editUserForm'])->name('edit-user');
    Route::post('/admin/add-user', [AdminController::class, 'addUserToPlatform']);
    Route::post('/user/delete', [UserController::class, 'delete'])->name('deleteUser');
    Route::post('/user/restore', [UserController::class, 'restore'])->name('restoreUser');
});

Route::group(['middleware' => ['auth', 'can:manage-platform']], function () {
    Route::post('admin/update-user', [AdminController::class, 'updateUserRoles']);
    Route::get('/communication/mailchimp', [CommunicationController::class, 'getMailChimpIntegration'])->name('mailchimp-integration.get');
    Route::post('/communication/mailchimp', [CommunicationController::class, 'storeMailChimpListsIds'])->name('mailchimp-integration');
    Route::get('/test-sentry/{message}', fn (Request $request) => throw new Exception('Test Sentry error: ' . $request->message));
    Route::get('/phpinfo', fn () => phpinfo());
    Route::get('/test-email/{email}', fn (Request $request) => User::where(['email' => $request->email])->first()->notify(new UserRegistered) && 'Success! Email sent to: ' . $request->email);
});

Route::group(['middleware' => ['auth', 'can:manage-platform-content']], function () {
    Route::resource('projects', CrowdSourcingProjectController::class)->except(['destroy']);
    Route::get('project/{id}/clone', [CrowdSourcingProjectController::class, 'clone'])->name('project.clone');
    Route::post('project/destroy', [CrowdSourcingProjectController::class, 'destroy'])->name('project.destroy');
    Route::get('/questionnaire/new', [QuestionnaireController::class, 'createQuestionnaire'])->name('create-questionnaire');
    Route::get('/questionnaire/{id}/edit', [QuestionnaireController::class, 'editQuestionnaire'])->name('edit-questionnaire');
    Route::post('/questionnaire/update-status', [QuestionnaireController::class, 'saveQuestionnaireStatus'])->name('questionnaire.update-status');
    Route::get('/questionnaires/{questionnaire}/colors', [QuestionnaireStatisticsController::class, 'showEditStatisticsColorsPage'])->name('questionnaire.statistics-colors');
    Route::post('/questionnaires/{questionnaire}/colors', [QuestionnaireStatisticsController::class, 'saveStatisticsColors'])->name('questionnaire.statistics-colors.store');
});

Route::group(['middleware' => ['auth', 'can:moderate-content-by-users']], function () {
    Route::get('/questionnaires', [QuestionnaireController::class, 'manageQuestionnaires'])->name('questionnaires.all');
    Route::get('/questionnaires/reports', [QuestionnaireReportController::class, 'viewReportsPage'])->name('questionnaires.reports');
    Route::get('/{project:slug}/questionnaire/{questionnaire:id}/moderator-add-answer', [QuestionnaireController::class, 'showAddResponseAsModeratorToQuestionnaire'])->name('questionnaire-moderator-add-response');
});

Route::group(['middleware' => 'auth'], function () {
    Route::post('/user/update', [UserController::class, 'patch'])->name('updateUser');
    Route::post('/user/deactivate', [UserController::class, 'deactivateLoggedInUser'])->name('deactivateUser');
    Route::get('/questionnaire/{questionnaire_id}/download-responses', [QuestionnaireResponseController::class, 'downloadQuestionnaireResponses'])->name('questionnaire.responses.download');
    Route::get('/user/my-data/download', [UserController::class, 'downloadMyData'])->name('my-data.download');
});

Route::group($localeInfo, function () {
    Route::get('/questionnaires/{questionnaire}/statistics/{projectFilter?}', [QuestionnaireStatisticsController::class, 'showStatisticsPageForQuestionnaire'])->name('questionnaire.statistics')->middleware('questionnaire.page_settings');
});

Route::post('/languages/setlocale', [LanguageController::class, 'setLocale'])->name('languages.setlocale');
Route::get('/{project:slug}/questionnaire/{questionnaire:id}/respond', [QuestionnaireController::class, 'showQuestionnairePage'])->name('show-questionnaire-page');

Route::group($localeInfo, function () {
    Route::get('/{project_slug}', [CrowdSourcingProjectController::class, 'showLandingPage'])->name('project.landing-page');
    Route::get('/{project_slug}/{questionnaire_id}/thanks', [QuestionnaireResponseController::class, 'showQuestionnaireThanksForRespondingPage'])->name('questionnaire.thanks');
    Route::get('/{project_slug}/problems', [CrowdSourcingProjectProblemController::class, 'showProblemsPage'])->name('project.problems-page');
});
