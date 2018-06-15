<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\UserManager;
use HttpException;
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

    public function addUserToPlatform(Request $request)
    {
        $result = $this->userManager->addUserToPlatform($request->email, $request->name, $request->surname, $request->password, $request->roleselect);
        switch ($result) {
            case "__USER_UPDATED":
                session()->flash('flash_message_success', 'User exists in platform. Their roles were updated.');
                break;
            case "__USER_ADDED":
                session()->flash('flash_message_success', 'User has been added to the platform.');
                break;
            default:
                throw new HttpException("Not a valid request");
        }
        return back();
    }
}