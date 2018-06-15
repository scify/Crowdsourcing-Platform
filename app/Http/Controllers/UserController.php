<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\UserManager;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $this->validate($request, [
            'password' => 'nullable|string|min:6|confirmed',
            'current_password' => 'required_with:password|string|min:6'
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
}