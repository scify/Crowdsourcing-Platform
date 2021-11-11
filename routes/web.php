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

use App\Http\Controllers\CrowdSourcingProjectController;
use App\Http\Controllers\QuestionnaireReportController;
use App\Http\Controllers\QuestionnaireResponseController;
use App\Models\User;
use App\Notifications\UserRegistered;

Auth::routes();

Route::get('login/social/{driver}', 'Auth\LoginController@redirectToProvider');
Route::get('login/social/{driver}/callback', 'Auth\LoginController@handleProviderCallback')->name('socialLoginCallback');
Route::get('/', 'HomeController@showHomePage')->name('home');
Route::post('/newsletter', 'CommunicationController@signUpForNewsletter')->name('newsletter');
Route::get('/terms-and-privacy', 'HomeController@showTermsAndPrivacyPage')->name('terms.privacy');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/my-dashboard', 'UserController@myDashboard')->name('my-dashboard');
    Route::get('/my-account', 'UserController@myAccount')->name('my-account');
    Route::get("/admin/manage-users", "AdminController@manageUsers")->middleware("can:manage-users");
    Route::get("/admin/edit-user/{id}", "AdminController@EditUserForm")->middleware("can:manage-users");
    Route::post("/admin/add-user", "AdminController@addUserToPlatform")->middleware("can:manage-users");
    Route::post("admin/update-user", "AdminController@updateUserRoles")->middleware("can:manage-platform");
    Route::post('/user/update', 'UserController@patch')->name('updateUser');
    Route::post('/user/delete', 'UserController@delete')->name('deleteUser')->middleware("can:manage-users");
    Route::post('/user/deactivate', 'UserController@deactivateLoggedInUser')->name('deactivateUser');
    Route::post('/user/restore', 'UserController@restore')->name('restoreUser')->middleware("can:manage-users");
    Route::get('/users/filter', 'UserController@showUsersByCriteria')->name('filterUsers')->middleware("can:manage-users");
    Route::get('/users/history', 'UserController@showUserHistory')->name('myHistory');
    Route::get('/users/data/download', 'UserController@downloadUserData')->name('downloadMyData');
    Route::resource('projects', 'CrowdSourcingProjectController')->except([
        'destroy'
    ])->middleware("can:manage-crowd-sourcing-projects");
    Route::get('project/{id}/clone', [CrowdSourcingProjectController::class, 'clone'])->name('project.clone')->middleware("can:manage-crowd-sourcing-projects");
    Route::post('project/destroy', [CrowdSourcingProjectController::class, 'destroy'])->name('project.destroy')->middleware("can:manage-crowd-sourcing-projects");

    Route::get('/questionnaires', 'QuestionnaireController@manageQuestionnaires')->name('questionnaires.all')->middleware("can:manage-crowd-sourcing-projects");
    Route::get('/questionnaires/reports', [QuestionnaireReportController::class, 'viewReportsPage'])->name('questionnaires.reports')->middleware("can:manage-crowd-sourcing-projects");
    Route::get('/questionnaire/new', 'QuestionnaireController@createQuestionnaire')->name('create-questionnaire')->middleware("can:manage-crowd-sourcing-projects");
    Route::get('questionnaire/report-data', [QuestionnaireReportController::class, 'getReportDataForQuestionnaire'])->name('questionnaire.get-report-data');
    Route::get('/questionnaire/{id}/edit', 'QuestionnaireController@editQuestionnaire')->name('edit-questionnaire')->middleware("can:manage-crowd-sourcing-projects");
    Route::post('/questionnaire/update-status', 'QuestionnaireController@saveQuestionnaireStatus')->name('update-questionnaire-status')->middleware("can:manage-crowd-sourcing-projects");
    Route::get('/questionnaires/{questionnaire}/colors', 'QuestionnaireStatisticsController@showEditStatisticsColorsPage')->name('statistics-colors-page')->middleware("can:manage-crowd-sourcing-projects");
    Route::post('/questionnaires/{questionnaire}/colors', 'QuestionnaireStatisticsController@saveStatisticsColors')->name('statistics-colors')->middleware("can:manage-crowd-sourcing-projects");
    Route::post('questionnaire/delete-response', [QuestionnaireResponseController::class, 'destroy'])->name('questionnaire_response.destroy');

    Route::get('/communication/mailchimp', 'CommunicationController@getMailChimpIntegration')->name('mailchimp-integration')->middleware("can:manage-platform");
    Route::post('/communication/mailchimp', 'CommunicationController@storeMailChimpListsIds')->name('mailchimp-integration')->middleware("can:manage-platform");
});

Route::get('/questionnaires/{questionnaire}/statistics',
    'QuestionnaireStatisticsController@showStatisticsPageForQuestionnaire')
    ->name('questionnaire.statistics')
    ->middleware('questionnaire.page_settings');

Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});

Route::get('/test-email/{email}', function () {
    User::where(['email' => request()->get('email')])->first()->notify(new UserRegistered());
});

Route::get('/{project_slug}', 'CrowdSourcingProjectController@showLandingPage')->name('project.landing-page');


