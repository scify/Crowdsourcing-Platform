<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\UserRegistered;
use Exception;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     */
    protected string $redirectTo = '/en/backoffice/my-dashboard';

    public function redirectTo(): string {
        return app()->getLocale() . '/backoffice/my-dashboard';
    }

    public function __construct(private \App\BusinessLogicLayer\User\UserRoleManager $userRoleManager,
        private \App\BusinessLogicLayer\User\UserManager $userManager,
        private \App\Utils\MailChimpAdaptor $mailChimpManager,
        private \App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectManager $crowdSourcingProjectManager,
        protected \App\BusinessLogicLayer\Questionnaire\QuestionnaireResponseManager $questionnaireResponseManager) {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
            'nickname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return \App\Models\User\User
     */
    protected function create(array $data) {
        $user = $this->userManager->createUser($data);
        $this->userRoleManager->assignRegisteredUserRoleTo($user);
        try {
            $user->notify(new UserRegistered);
        } catch (Exception $e) {
            Log::error($e);
        }

        return $user;
    }

    /**
     * @throws Exception
     */
    protected function registered(Request $request, $user) {
        $this->mailChimpManager->subscribe($user->email, 'registered_users', $user->nickname);
        $numberOfResponseTransferred = $this->questionnaireResponseManager->transferQuestionnaireResponsesOfAnonymousUserToUser($user);
        if ($numberOfResponseTransferred !== 0) {
            session()->flash('flash_message_success', 'Thanks for answering! ');
        }

        $url = session('redirectTo') ?: $this->redirectTo();

        return redirect($url);
    }
}
