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
    Route::get("/admin/manage-users", "CmsAdminController@manageUsers")->middleware("can:manage-cms");
    Route::get("/admin/edit-user/{id}", "CmsAdminController@cmsEditUser")->middleware("can:manage-cms");
    Route::post("/admin/invite-user", "CmsAdminController@inviteUserToCms")->middleware("can:manage-cms");
    Route::post("admin/update-user", "CmsAdminController@updateUserRoles")->middleware("can:manage-cms");
});



