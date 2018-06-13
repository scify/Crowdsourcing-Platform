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
        return view('home.my-profile', ['userViewModel' => $userViewModel]);
    }

    public function patch(Request $request) {
        $this->validate($request, [
            'password' => 'required|string|min:6|confirmed',
            'current_password' => 'required|string|min:6'
        ]);
        $data = $request->all();
        $current_password = Auth::User()->password;
        if(Hash::check($data['current_password'], $current_password)) {
            $user_id = Auth::User()->id;
            $obj_user = User::find($user_id);
            $obj_user->password = Hash::make($data['password']);
            $obj_user->save();
            session()->flash('flash_message_success', 'Profile updated.');
        } else {
            session()->flash('flash_message_failure', 'Please enter correct current password.');
        }
        return back();
    }
}