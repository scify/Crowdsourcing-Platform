<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\UserManager;
use Illuminate\Http\Request;

class AdminController extends Controller {

    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    public function manageUsers()
    {
        $viewModel = $this->userManager->getManageUsersViewModel();
        return view('admin.manage-users', ['viewModel' => $viewModel]);
    }

    public function editUserForm($id)
    {
        $viewModel = $this->userManager->getEditUserViewModel($id);
        return view('admin.edit-user', ['viewModel' => $viewModel]);
    }

    public function updateUserRoles(Request $request)
    {
        $this->userManager->updateUserRoles($request->userId, $request->roleselect);
        return redirect('/admin/manage-users');
    }
}