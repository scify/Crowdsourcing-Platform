<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\UserManager;
use Auth;

class HomeController extends Controller
{
    private $userManager;

    /**
     * Create a new controller instance.
     *
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->middleware('auth');
        $this->userManager = $userManager;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($this->userManager->userIsPlatformAdmin(Auth::user()))
            return redirect("/platform-admin/manage-payments");
        else
            return redirect("/my-profile");

    }
}
