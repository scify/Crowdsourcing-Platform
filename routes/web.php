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

// TODO: change "fair-eu" to make it using project slug from db?
Route::get('/', function() {
    return redirect('/fair-eu');
});
Route::get('/fair-eu', 'CrowdSourcingProjectController@showLandingPage');

Route::get('/home', 'HomeController@index');

Route::group([ 'middleware' => 'auth' ], function () {
    Route::get('/my-profile', 'UserController@myProfile')->name('profile')->middleware("can:view-my-profile");
    Route::get("/admin/manage-users", "AdminController@manageUsers")->middleware("can:manage-users");
    Route::get("/admin/edit-user/{id}", "AdminController@EditUserForm")->middleware("can:manage-users");
    Route::post("/admin/add-user", "AdminController@addUserToPlatform")->middleware("can:manage-users");
    Route::post("admin/update-user", "AdminController@updateUserRoles")->middleware("can:manage-platform");
    Route::post('/user/update', 'UserController@patch')->name('updateUser')->middleware("can:view-my-profile");
    Route::post('/user/delete', 'UserController@delete')->name('deleteUser')->middleware("can:manage-users");
    Route::post('/user/restore', 'UserController@restore')->name('restoreUser')->middleware("can:manage-users");
    Route::get('/users/filter', 'UserController@showUsersByCriteria')->name('filterUsers')->middleware("can:manage-users");
    Route::get('/project/{id}/edit', 'CrowdSourcingProjectController@edit')->name('editProject')->middleware("can:manage-crowd-sourcing-projects");
});




