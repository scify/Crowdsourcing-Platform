<?php

namespace App\Http\Controllers\Auth;

use App\BusinessLogicLayer\UserManager;
use App\BusinessLogicLayer\UserRoles;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/my-profile';

    private $userManager;

    public function __construct(UserManager $userManager) {
        $this->middleware('guest')->except('logout');
        $this->userManager = $userManager;
    }


    public function redirectToProvider( $driver) {
        //todo:
        return Socialite::driver($driver)->redirect();
    }

    public function handleProviderCallback(Request $request, $driver) {
        $socialUser = Socialite::driver($driver)->user();
        try {
            $user = $this->userManager->handleSocialLoginUser($socialUser);
            session()->flash('flash_message_success', 'Welcome, ' . $user->nickname . '!');
        } catch (\Exception $e) {
            session()->flash('flash_message_failure', 'Error: ' . $e->getMessage());
        }
        return redirect('/');
    }
}
