<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\UserManager;
use App\Http\OperationResponse;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    public function myProfile()
    {
        $userViewModel = $this->userManager->getMyProfileData(Auth::user());
        return view('home.my-profile', ['viewModel' => $userViewModel]);
    }

    public function patch(Request $request) {
        if($request->password)
            $this->validate($request, [
                'password' => 'required|string|min:6|confirmed',
                'current_password' => 'required|string|min:6'
            ]);
        $data = $request->all();
        try {
            $this->userManager->updateUser($data);
            session()->flash('flash_message_success', 'Profile updated.');
        } catch (\Exception $e) {
            session()->flash('flash_message_failure', 'Error: ' . $e->getMessage());
        }
        return back();
    }

    public function delete(Request $request) {
        try {
            $this->userManager->deactivateUser($request->id);
            session()->flash('flash_message_success', 'User deleted.');
        } catch (\Exception $e) {
            session()->flash('flash_message_failure', 'Error: ' . $e->getMessage());
        }
        return back();
    }

    public function restore(Request $request) {
        try {
            $this->userManager->reactivateUser($request->id);
            session()->flash('flash_message_success', 'User restored.');
        } catch (\Exception $e) {
            session()->flash('flash_message_failure', 'Error: ' . $e->getMessage());
        }
        return back();
    }

    public function showUsersByCriteria(Request $request) {
        $input = $request->all();
        try {
            $users = $this->userManager->getUsersWithCriteria(2, $input);
            $users->withPath('manage-users');
        }  catch (\Exception $e) {
            $errorMessage = 'Error: ' . $e->getCode() . "  " .  $e->getMessage();
            return json_encode(new OperationResponse(config('app.OPERATION_FAIL'), (String) view('common.ajax_error_message', compact('errorMessage'))));
        }
        if($users->count() == 0) {
            $errorMessage = "No Users found";
            return json_encode(new OperationResponse(config('app.OPERATION_FAIL'), (String) view('common.ajax_error_message', compact('errorMessage'))));
        } else {
            return json_encode(new OperationResponse(config('app.OPERATION_SUCCESS'), (String) view('admin.users-list', compact('users'))));
        }
    }
}