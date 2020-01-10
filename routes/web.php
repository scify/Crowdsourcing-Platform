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

Auth::routes();

Route::get('login/social/{driver}', 'Auth\LoginController@redirectToProvider');
Route::get('login/social/{driver}/callback', 'Auth\LoginController@handleProviderCallback')->name('facebookLogin');
Route::get('/', 'HomeController@showHomePage')->name('home');
Route::get('/terms-and-privacy', 'HomeController@termsAndPrivacyPage')->name('terms-and-privacy');
Route::post('/newsletter', 'CommunicationController@signUpForNewsletter')->name('newsletter');

Route::group([ 'middleware' => 'auth' ], function () {
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
    Route::post('project/destroy', 'CrowdSourcingProjectController@destroy')->name('project.destroy')->middleware("can:manage-crowd-sourcing-projects");

    Route::get('/questionnaires', 'QuestionnaireController@manageQuestionnaires')->name('questionnaires.all')->middleware("can:manage-crowd-sourcing-projects");
    Route::get('/project/{id}/reports', 'CrowdSourcingProjectController@viewReports')->name('project.reports')->middleware("can:manage-crowd-sourcing-projects");
    Route::get('/questionnaire/new', 'QuestionnaireController@createQuestionnaire')->name('create-questionnaire')->middleware("can:manage-crowd-sourcing-projects");
    Route::get('questionnaire/filter', 'QuestionnaireController@showReportForQuestionnaire')->name('questionnaireReport');
    Route::post('/questionnaire/new', 'QuestionnaireController@storeQuestionnaire')->name('create-questionnaire')->middleware("can:manage-crowd-sourcing-projects");
    Route::get('/questionnaire/{id}/edit', 'QuestionnaireController@editQuestionnaire')->name('edit-questionnaire')->middleware("can:manage-crowd-sourcing-projects");
    Route::post('/questionnaire/{id}/edit', 'QuestionnaireController@updateQuestionnaire')->name('edit-questionnaire')->middleware("can:manage-crowd-sourcing-projects");
    Route::get('/questionnaire/{id}/translate', 'QuestionnaireController@translateQuestionnaire')->name('translate-questionnaire')->middleware("can:manage-crowd-sourcing-projects");
    Route::post('/questionnaire/{id}/translate', 'QuestionnaireController@storeQuestionnaireTranslations')->name('translate-questionnaire')->middleware("can:manage-crowd-sourcing-projects");
    Route::post('/questionnaire/update-status', 'QuestionnaireController@saveQuestionnaireStatus')->name('update-questionnaire-status')->middleware("can:manage-crowd-sourcing-projects");
    Route::post('/questionnaire/respond', 'QuestionnaireController@storeQuestionnaireResponse')->name('respond-questionnaire');
//    Route::post('/questionnaire/share', 'QuestionnaireController@storeQuestionnaireShare')->name('share-questionnaire');
    Route::post('automatic-translation', 'QuestionnaireController@getAutomaticTranslations')->name('automatic-translation');
    Route::post('mark-translation', 'QuestionnaireController@markTranslation')->name('mark-translation');
    Route::post('delete-translation', 'QuestionnaireController@deleteTranslation')->name('delete-translation');
    Route::post('automatic-translation-single-string', 'QuestionnaireController@getAutomaticTranslationForString')->name('automatic-translation-single-string');

    Route::get('/communication/mailchimp', 'CommunicationController@getMailChimpIntegration')->name('mailchimp-integration')->middleware("can:manage-platform");
    Route::post('/communication/mailchimp', 'CommunicationController@storeMailChimpListsIds')->name('mailchimp-integration')->middleware("can:manage-platform");
});

Route::get('/{project_slug}', 'CrowdSourcingProjectController@showLandingPage')->name('project.landing-page');


