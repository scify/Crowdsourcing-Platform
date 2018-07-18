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

Route::group([ 'middleware' => 'auth' ], function () {
    Route::get('/', 'UserController@home');
    Route::get('/my-profile', 'UserController@myProfile')->name('profile');
    Route::get('/contribute', 'UserController@contribute')->name('contribute');
    Route::get("/admin/manage-users", "AdminController@manageUsers")->middleware("can:manage-users");
    Route::get("/admin/edit-user/{id}", "AdminController@EditUserForm")->middleware("can:manage-users");
    Route::post("/admin/add-user", "AdminController@addUserToPlatform")->middleware("can:manage-users");
    Route::post("admin/update-user", "AdminController@updateUserRoles")->middleware("can:manage-platform");
    Route::post('/user/update', 'UserController@patch')->name('updateUser');
    Route::post('/user/delete', 'UserController@delete')->name('deleteUser')->middleware("can:manage-users");
    Route::post('/user/restore', 'UserController@restore')->name('restoreUser')->middleware("can:manage-users");
    Route::get('/users/filter', 'UserController@showUsersByCriteria')->name('filterUsers')->middleware("can:manage-users");
    Route::get('/project/{id}/edit', 'CrowdSourcingProjectController@edit')->name('editProject')->middleware("can:manage-crowd-sourcing-projects");
    Route::post('/project/{id}/update', 'CrowdSourcingProjectController@update')->name('updateProject')->middleware("can:manage-crowd-sourcing-projects");
    Route::get('/project/{id}/questionnaires', 'QuestionnaireController@manageQuestionnaires')->name('manageQuestionnaires')->middleware("can:manage-crowd-sourcing-projects");
    Route::get('/project/{id}/reports', 'CrowdSourcingProjectController@viewReports')->name('reports')->middleware("can:manage-crowd-sourcing-projects");
    Route::get('/questionnaire/new', 'QuestionnaireController@createQuestionnaire')->name('create-questionnaire')->middleware("can:manage-crowd-sourcing-projects");
    Route::post('/questionnaire/new', 'QuestionnaireController@storeQuestionnaire')->name('create-questionnaire')->middleware("can:manage-crowd-sourcing-projects");
    Route::get('/questionnaire/{id}/edit', 'QuestionnaireController@editQuestionnaire')->name('edit-questionnaire')->middleware("can:manage-crowd-sourcing-projects");
    Route::post('/questionnaire/{id}/edit', 'QuestionnaireController@updateQuestionnaire')->name('edit-questionnaire')->middleware("can:manage-crowd-sourcing-projects");
    Route::get('/questionnaire/{id}/translate', 'QuestionnaireController@translateQuestionnaire')->name('translate-questionnaire')->middleware("can:manage-crowd-sourcing-projects");
    Route::post('/questionnaire/{id}/translate', 'QuestionnaireController@storeQuestionnaireTranslations')->name('translate-questionnaire')->middleware("can:manage-crowd-sourcing-projects");
    Route::post('/questionnaire/update-status', 'QuestionnaireController@saveQuestionnaireStatus')->name('update-questionnaire-status')->middleware("can:manage-crowd-sourcing-projects");
    Route::post('/questionnaire/respond', 'QuestionnaireController@storeQuestionnaireResponse')->name('respond-questionnaire');
});

Route::get('/{project_slug}', 'CrowdSourcingProjectController@showLandingPage');


