<?php

namespace App\Http\Controllers\Auth;

use App\BusinessLogicLayer\questionnaire\QuestionnaireResponseManager;
use App\BusinessLogicLayer\UserManager;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\Response as Response;
use Throwable;

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
     */
    protected string $redirectTo = '/en/my-dashboard';

    protected ExceptionHandler $exceptionHandler;

    public function redirectTo() {
        return app()->getLocale() . '/my-dashboard';
    }

    protected UserManager $userManager;
    protected QuestionnaireResponseManager $questionnaireResponseManager;

    public function __construct(UserManager $userManager,
        QuestionnaireResponseManager $questionnaireResponseManager,
        ExceptionHandler $handler) {
        $this->exceptionHandler = $handler;
        $this->middleware('guest')->except('logout');
        $this->userManager = $userManager;
        $this->questionnaireResponseManager = $questionnaireResponseManager;
    }

    public function showLoginForm(Request $request, $redirectTo) {
        $r = $request->query('redirectTo') ? $request->query('redirectTo') : $this->redirectTo();
        $request->session()->put('redirectTo', $r);

        return view('auth.login')->with('displayQuestionnaireLabels', $request->submitQuestionnaire != null);
    }

    protected function authenticated(Request $request, $user) {
        $numberOfResponsesTransferred = $this->questionnaireResponseManager->transferQuestionnaireResponsesOfAnonymousUserToUser($user);
        $url = session('redirectTo') ? session('redirectTo') : $this->redirectTo();
        if ($numberOfResponsesTransferred) {
            session()->flash('flash_message_success', 'Thanks for answering! ');
        }

        return redirect($url);
    }

    public function redirectToProvider($driver) {
        try {
            return Socialite::driver($driver)->redirect();
        } catch (Exception $e) {
            $this->exceptionHandler->report($e);
            abort(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @throws Throwable
     */
    public function handleProviderCallback(Request $request, $driver) {
        if (isset($request['denied']) || isset($request['error'])) {
            $this->exceptionHandler->report(new Exception($request['error']));

            return redirect()->route('home', ['locale' => app()->getLocale()]);
        }

        $socialUser = Socialite::driver($driver)->user();
        $user = $this->userManager->handleSocialLoginUser($socialUser);

        return $this->authenticated($request, $user);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home', ['locale' => app()->getLocale()]);
    }
}
