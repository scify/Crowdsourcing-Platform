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

Route::group([ 'middleware' => 'auth' ], function () {
    Route::get('/', 'HomeController@index');
    Route::get('/my-profile', 'UserController@myProfile')->name('profile')->middleware("can:view-my-profile");
    Route::get("/admin/manage-users", "AdminController@manageUsers")->middleware("can:manage-users");
    Route::get("/admin/edit-user/{id}", "AdminController@EditUserForm")->middleware("can:manage-users");
    Route::post("/admin/add-user", "AdminController@addUserToPlatform")->middleware("can:manage-users");
    Route::post("admin/update-user", "AdminController@updateUserRoles")->middleware("can:manage-platform");
    Route::post('/user/update', 'UserController@patch')->name('updateUser')->middleware("can:view-my-profile");
    Route::post('/user/disable', 'UserController@delete')->name('deleteUser')->middleware("can:manage-users");
});



