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

use App\Http\Controllers\CrowdSourcingProjectColorsController;
use App\Http\Controllers\CrowdSourcingProjectController;
use App\Http\Controllers\QuestionnaireAnswerAnnotationController;
use App\Http\Controllers\QuestionnaireReportController;
use App\Http\Controllers\QuestionnaireResponseController;
use App\Models\User;
use App\Notifications\UserRegistered;
use Illuminate\Http\Request;


Route::get('/', function () {
    return redirect(app()->getLocale());
});


$regexForLocalParameter= config("app.regex_for_validating_locale_at_routes");
//notice we use this also for /my-dashbor and /my-account
$localeInfo = ['prefix' => '{locale}',
               'where' => ['locale' => $regexForLocalParameter],
               'middleware' => 'setlocale'
                ];
Route::group($localeInfo, function () {
    Auth::routes();
    Route::get('/', 'HomeController@showHomePage')->name('home');
    Route::get('/terms-and-privacy', 'HomeController@showTermsAndPrivacyPage')->name('terms.privacy');
    Route::get('/code-of-conduct', 'HomeController@showCodeOfConductPage')->name('codeOfConduct');
});

Route::get('/terms-and-privacy', function () {
    return redirect(app()->getLocale() ."/terms-and-privacy");
});
Route::get('/code-of-conduct', function () {
    return redirect(app()->getLocale() ."/code-of-conduct");
});


Route::get('login/social/{driver}', 'Auth\LoginController@redirectToProvider');
Route::get('login/social/{driver}/callback', 'Auth\LoginController@handleProviderCallback')->name('socialLoginCallback');

Route::post('/newsletter', 'CommunicationController@signUpForNewsletter')->name('newsletter');

Route::group(['prefix' => '{locale}',
    'where' => ['locale' => $regexForLocalParameter],
    'middleware' => ['auth', 'setlocale'],
], function () {
    Route::get('/my-dashboard', 'UserController@myDashboard')->name('my-dashboard');
    Route::get('/my-account', 'UserController@myAccount')->name('my-account');
    Route::get('/users/history', 'UserController@showUserHistory')->name('myHistory');
});

Route::group(['middleware' => 'auth'], function () {

    Route::get("/admin/manage-users", "AdminController@manageUsers")->name('manage-users')->middleware("can:manage-users");
    Route::get("/admin/edit-user/{id}", "AdminController@EditUserForm")->name('edit-user')->middleware("can:manage-users");
    Route::post("/admin/add-user", "AdminController@addUserToPlatform")->middleware("can:manage-users");
    Route::post("admin/update-user", "AdminController@updateUserRoles")->middleware("can:manage-platform");
    Route::post('/user/update', 'UserController@patch')->name('updateUser');
    Route::post('/user/delete', 'UserController@delete')->name('deleteUser')->middleware("can:manage-users");
    Route::post('/user/deactivate', 'UserController@deactivateLoggedInUser')->name('deactivateUser');
    Route::post('/user/restore', 'UserController@restore')->name('restoreUser')->middleware("can:manage-users");
    Route::get('/users/filter', 'UserController@showUsersByCriteria')->name('filterUsers')->middleware("can:manage-users");

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

    Route::get('/communication/mailchimp', 'CommunicationController@getMailChimpIntegration')->name('mailchimp-integration.get')->middleware("can:manage-platform");
    Route::post('/communication/mailchimp', 'CommunicationController@storeMailChimpListsIds')->name('mailchimp-integration')->middleware("can:manage-platform");
});


Route::group($localeInfo, function () {
    Route::get('/questionnaires/{questionnaire}/statistics',
        'QuestionnaireStatisticsController@showStatisticsPageForQuestionnaire')
        ->name('questionnaire.statistics')
        ->middleware('questionnaire.page_settings');
});


Route::group(['middleware' => 'auth'], function () {
    Route::get('/test-sentry/{message}', function (Request $request) {
        throw new Exception('Test Sentry error: ' . $request->message);
    })->middleware("can:manage-platform");

    Route::get('/test-email/{email}', function (Request $request) {
        User::where(['email' => $request->email])->first()->notify(new UserRegistered());
        return "Success! Email sent to: " . $request->email;
    })->middleware("can:manage-platform");
});


Route::group($localeInfo, function () {
    Route::get('/{project_slug}', 'CrowdSourcingProjectController@showLandingPage')->name('project.landing-page');
});






