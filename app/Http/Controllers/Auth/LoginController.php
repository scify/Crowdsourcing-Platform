<?php

namespace App\Http\Controllers\Auth;

use App\BusinessLogicLayer\UserManager;
use App\BusinessLogicLayer\UserRoles;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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


    public function __construct(UserManager $userManager)
    {
        $this->middleware('guest')->except('logout');
        $this->userManager = $userManager;
    }

    public function showLoginForm(Request $request)
    {
        $request->session()->put("redirectTo", $request->redirectTo);
        return view('auth.login')->with("displayQuestionnaireLabels", $request->submitQuestionnaire != null);
    }

    protected function authenticated(Request $request, $user)
    {
        $redirectToOverrideUrl = session("redirectTo");
        if ($redirectToOverrideUrl)
            return redirect($redirectToOverrideUrl);
        else
            return redirect($this->redirectTo);
    }


    public function redirectToProvider($driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    public function handleProviderCallback(Request $request, $driver)
    {
        $socialUser = Socialite::driver($driver)->user();
        $user = $this->userManager->handleSocialLoginUser($socialUser);
        session()->flash('flash_message_success', 'Welcome, ' . $user->nickname . '!');
        return $this->authenticated($request,$user);
    }
}
