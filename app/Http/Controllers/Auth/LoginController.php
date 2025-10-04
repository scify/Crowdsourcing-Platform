<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\BusinessLogicLayer\Questionnaire\QuestionnaireResponseManager;
use App\BusinessLogicLayer\User\UserManager;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\Response;
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
    protected string $redirectTo = '/en/backoffice/my-dashboard';

    public function redirectTo(): string {
        return app()->getLocale() . '/backoffice/my-dashboard';
    }

    public function __construct(protected UserManager $userManager,
        protected QuestionnaireResponseManager $questionnaireResponseManager,
        protected ExceptionHandler $exceptionHandler) {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(Request $request, $redirectTo) {
        $r = $request->query('redirectTo') ?: $this->redirectTo();
        $request->session()->put('redirectTo', $r);

        return view('auth.login')->with('displayQuestionnaireLabels', $request->submitQuestionnaire != null);
    }

    protected function authenticated(Request $request, \App\Models\User\User $user): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse {
        $numberOfResponsesTransferred = $this->questionnaireResponseManager->transferQuestionnaireResponsesOfAnonymousUserToUser($user);
        $url = session('redirectTo') ?: $this->redirectTo();
        if ($numberOfResponsesTransferred !== 0) {
            session()->flash('flash_message_success', 'Thanks for answering! ');
        }

        return redirect($url);
    }

    public function redirectToProvider($driver) {
        try {
            return Socialite::driver($driver)->redirect();
        } catch (Exception $exception) {
            $this->exceptionHandler->report($exception);
            abort(Response::HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
        }

        return null;
    }

    /**
     * @throws Throwable
     */
    public function handleProviderCallback(Request $request, $driver) {
        if (isset($request['denied']) || isset($request['error'])) {
            if (isset($request['denied'])) {
                session()->flash('flash_message_error', 'You have denied the login request');
            } else {
                $this->exceptionHandler->report(new Exception($request['error']));
            }

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
