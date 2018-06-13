<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\ImageManager;
use App\BusinessLogicLayer\UserManager;
use App\Models\ViewModels\UserProfile;
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
        return view('home.my-profile', ['userViewModel' => $userViewModel]);
    }

    public function updateLocation(Request $request)
    {
        $this->validate($request, [
            'location_name' => 'required|string',
            'lat' => 'required|min:-90|max:90|numeric',
            'lon' => 'required|min:-180|max:180|numeric'
        ]);
        $this->userManager->updateLocation(Auth::user(), $request->location_name, $request->lat, $request->lon);
        session()->flash('flash_message_success', 'Location has been updated.');
        return back();
    }
}