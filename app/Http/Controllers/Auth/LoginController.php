<?php

namespace App\Http\Controllers\Auth;

use App\BusinessLogicLayer\questionnaire\QuestionnaireActionHandler;
use App\BusinessLogicLayer\questionnaire\QuestionnaireResponseManager;
use App\BusinessLogicLayer\UserManager;
use App\Http\Controllers\Controller;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller {
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
    protected $redirectTo = '/en/my-dashboard';
    public function redirectTo()
    {
        return app()->getLocale() . '/my-dashboard';
    }

    protected UserManager $userManager;
    protected QuestionnaireResponseManager $questionnaireResponseManager;


    public function __construct(UserManager                     $userManager,
                                QuestionnaireResponseManager $questionnaireResponseManager) {
        $this->middleware('guest')->except('logout');
        $this->userManager = $userManager;
        $this->questionnaireResponseManager = $questionnaireResponseManager;
    }

    public function showLoginForm(Request $request) {
        $request->session()->put("redirectTo", $request->redirectTo);
        return view('auth.login')->with("displayQuestionnaireLabels", $request->submitQuestionnaire != null);
    }

    protected function authenticated(Request $request, $user) {
        $numberOfResponsedTransfered = $this->questionnaireResponseManager->transferQuestionnaireResponsesOfAnonymousUserToUser($user);
        $url = session("redirectTo") ? session("redirectTo") : $this->redirectTo;
        if ($numberOfResponsedTransfered)
            session()->flash('flash_message_success', 'Thanks for answering! ');

        return redirect($url);
    }


    public function redirectToProvider($driver) {
        return Socialite::driver($driver)->redirect();
    }

    public function handleProviderCallback(Request $request, $driver) {
        if (isset($request['denied']) || isset($request['error']))
            return redirect()->route('home');
        $socialUser = Socialite::driver($driver)->user();
        $user = $this->userManager->handleSocialLoginUser($socialUser);
        return $this->authenticated($request, $user);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }


}
