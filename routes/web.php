<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\CrowdSourcingProject\CrowdSourcingProjectController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Problem\ProblemController;
use App\Http\Controllers\Questionnaire\QuestionnaireController;
use App\Http\Controllers\Questionnaire\QuestionnaireReportController;
use App\Http\Controllers\Questionnaire\QuestionnaireResponseController;
use App\Http\Controllers\Questionnaire\QuestionnaireStatisticsController;
use App\Http\Controllers\Solution\SolutionController;
use App\Http\Controllers\User\AdminController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect(app()->getLocale()));

$backOfficePrefix = 'backoffice';

$localeInfo = [
    'prefix' => '{locale}',
    'where' => ['locale' => config('app.regex_for_validating_locale_at_routes')],
    'middleware' => 'setlocale',
];

Route::group($localeInfo, function (): void {
    Auth::routes();
    Route::get('/', [HomeController::class, 'showHomePage'])->name('home');
    Route::get('/terms-and-privacy', [HomeController::class, 'showTermsAndPrivacyPage'])->name('terms.privacy');
    Route::get('/code-of-conduct', [HomeController::class, 'showCodeOfConductPage'])->name('code-of-conduct');
});

Route::get('/terms-and-privacy', fn () => redirect(app()->getLocale() . '/terms-and-privacy'));
Route::get('/code-of-conduct', fn () => redirect(app()->getLocale() . '/code-of-conduct'));

Route::get('login/social/{driver}', [LoginController::class, 'redirectToProvider']);
Route::get('login/social/{driver}/callback', [LoginController::class, 'handleProviderCallback'])->name('socialLoginCallback');

Route::group(['middleware' => ['auth', 'setlocale']], function () use ($localeInfo, $backOfficePrefix): void {
    Route::group($localeInfo, function () use ($backOfficePrefix): void {
        Route::group(['prefix' => $backOfficePrefix], function (): void {
            Route::get('/my-dashboard', [UserController::class, 'myDashboard'])->name('my-dashboard');
            Route::get('/my-account', [UserController::class, 'myAccount'])->name('my-account');
            Route::get('/my-contributions', [UserController::class, 'showUserContributions'])->name('my-contributions');
        });
    });
});

Route::group(['middleware' => ['auth', 'can:manage-users']], function () use ($backOfficePrefix): void {
    Route::group(['prefix' => $backOfficePrefix], function (): void {
        Route::get('/manage-users', [AdminController::class, 'manageUsers'])->name('manage-users');
        Route::get('/edit-user/{id}', [AdminController::class, 'editUserForm'])->name('edit-user');
        Route::post('/add-user', [AdminController::class, 'addUserToPlatform']);
        Route::post('/user/delete', [UserController::class, 'delete'])->name('deleteUser');
        Route::post('/user/restore', [UserController::class, 'restore'])->name('restoreUser');
    });
});

Route::group(['middleware' => ['auth', 'can:manage-platform']], function () use ($backOfficePrefix): void {
    Route::group(['prefix' => $backOfficePrefix], function (): void {
        Route::post('update-user', [AdminController::class, 'updateUserRoles']);
        Route::get('/communication/mailchimp', [CommunicationController::class, 'getMailChimpIntegration'])->name('mailchimp-integration.get');
        Route::post('/communication/mailchimp', [CommunicationController::class, 'storeMailChimpListsIds'])->name('mailchimp-integration');
    });
    Route::middleware(['throttle:api-public'])->group(function (): void {
        Route::group(['prefix' => 'admin'], function (): void {
            Route::get('/check-upload', [AdminController::class, 'checkUploadPage']);
            Route::post('/upload-files', [AdminController::class, 'uploadAdminFile'])->name('admin.image.upload');
        });
    });
});

Route::group(['middleware' => ['auth', 'can:manage-platform-content']], function () use ($localeInfo, $backOfficePrefix): void {
    Route::group($localeInfo, function () use ($backOfficePrefix): void {
        Route::group(['prefix' => $backOfficePrefix], function (): void {
            Route::resource('projects', CrowdSourcingProjectController::class)->except(['destroy']);
            Route::get('project/{id}/clone', [CrowdSourcingProjectController::class, 'clone'])->name('project.clone');
            Route::post('project/destroy', [CrowdSourcingProjectController::class, 'destroy'])->name('project.destroy');
            Route::get('/questionnaire/new', [QuestionnaireController::class, 'createQuestionnaire'])->name('create-questionnaire');
            Route::get('/questionnaire/{id}/edit', [QuestionnaireController::class, 'editQuestionnaire'])->name('edit-questionnaire');
            Route::post('/questionnaire/update-status', [QuestionnaireController::class, 'saveQuestionnaireStatus'])->name('questionnaire.update-status');
            Route::get('/questionnaires/{questionnaire}/colors', [QuestionnaireStatisticsController::class, 'showEditStatisticsColorsPage'])->name('questionnaire.statistics-colors');
            Route::post('/questionnaires/{questionnaire}/colors', [QuestionnaireStatisticsController::class, 'saveStatisticsColors'])->name('questionnaire.statistics-colors.store');
            Route::resource('problems', ProblemController::class)->except(['show']);
            Route::resource('solutions', SolutionController::class)->except(['show']);
        });
    });
});

Route::group(['middleware' => ['auth', 'can:moderate-content-by-users', 'setlocale']], function () use ($localeInfo, $backOfficePrefix): void {
    Route::group($localeInfo, function () use ($backOfficePrefix): void {
        Route::group(['prefix' => $backOfficePrefix], function (): void {
            Route::get('/questionnaires', [QuestionnaireController::class, 'manageQuestionnaires'])->name('questionnaires.all');
            Route::get('/questionnaires/reports', [QuestionnaireReportController::class, 'viewReportsPage'])->name('questionnaires.reports');
            Route::get('/{project:slug}/questionnaire/{questionnaire:id}/moderator-add-answer', [QuestionnaireController::class, 'showAddResponseAsModeratorToQuestionnaire'])->name('questionnaire-moderator-add-response');
        });
    });
});

Route::group(['middleware' => 'auth'], function () use ($backOfficePrefix): void {
    Route::group(['prefix' => $backOfficePrefix], function (): void {
        Route::put('/user/update', [UserController::class, 'patch'])->name('user.update');
        Route::post('/user/deactivate', [UserController::class, 'deactivateLoggedInUser'])->name('user.deactivate');
        Route::get('/questionnaire/{questionnaire_id}/download-responses', [QuestionnaireResponseController::class, 'downloadQuestionnaireResponses'])->name('questionnaire.responses.download');
        Route::get('/user/my-data/download', [UserController::class, 'downloadMyData'])->name('my-data.download');
    });
});

Route::group($localeInfo, function (): void {
    Route::get('/questionnaires/{questionnaire}/statistics/{projectFilter?}', [QuestionnaireStatisticsController::class, 'showStatisticsPageForQuestionnaire'])
        ->name('questionnaire.statistics')->middleware('questionnaire.page_settings');
});

Route::group($localeInfo, function (): void {
    Route::post('/languages/setlocale', [LanguageController::class, 'setLocale'])->name('languages.setlocale');
});
Route::group(['middleware' => ['setlocale']], function () use ($localeInfo): void {
    Route::group($localeInfo, function (): void {
        Route::get('/{slug}', [CrowdSourcingProjectController::class, 'showLandingPage'])->name('project.landing-page');
        Route::get('/{project_slug}/{questionnaire_id}/{response_id}/thanks', [QuestionnaireResponseController::class, 'showQuestionnaireThanksForRespondingPage'])->name('questionnaire.thanks');
        Route::get('/{project_slug}/problems', [ProblemController::class, 'showProblemsPage'])->name('project.problems-page');
        Route::get('/{project_slug}/problems/{problem_slug}', [ProblemController::class, 'show'])->name('problem.show');
        Route::get('/{project_slug}/problems/{problem_slug}/solutions/', [ProblemController::class, 'show'])->name('problem.show.solutions');
        Route::get('/{project_slug}/problems/{problem_slug}/solutions/propose', [SolutionController::class, 'userProposalCreate'])->name('solutions.user-proposal-create');
        Route::post('/{project_slug}/problems/{problem_slug}/solutions', [SolutionController::class, 'userProposalStore'])->name('solutions.user-proposal-store');
        Route::get('/{project_slug}/problems/{problem_slug}/solutions/{solution_slug}/submitted', [SolutionController::class, 'userProposalSubmitted'])->name('solutions.user-proposal-submitted');
        Route::get('/{project:slug}/questionnaire/{questionnaire:id}/respond', [QuestionnaireController::class, 'showQuestionnairePage'])->name('show-questionnaire-page');
    });
});
