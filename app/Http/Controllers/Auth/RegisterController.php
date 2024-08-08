<?php

namespace App\Http\Controllers\Auth;

use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectManager;
use App\BusinessLogicLayer\questionnaire\QuestionnaireResponseManager;
use App\BusinessLogicLayer\UserManager;
use App\BusinessLogicLayer\UserRoleManager;
use App\Http\Controllers\Controller;
use App\Notifications\UserRegistered;
use App\Utils\MailChimpAdaptor;
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
    protected string $redirectTo = '/en/my-dashboard';

    public function redirectTo() {
        return app()->getLocale() . '/my-dashboard';
    }

    private $userRoleManager;
    private $userManager;
    private $mailChimpManager;
    private $crowdSourcingProjectManager;
    protected $questionnaireResponseManager;

    public function __construct(UserRoleManager $userRoleManager,
        UserManager $userManager,
        MailChimpAdaptor $mailChimpManager,
        CrowdSourcingProjectManager $crowdSourcingProjectManager,
        QuestionnaireResponseManager $questionnaireResponseManager) {
        $this->middleware('guest');
        $this->userRoleManager = $userRoleManager;
        $this->userManager = $userManager;
        $this->mailChimpManager = $mailChimpManager;
        $this->crowdSourcingProjectManager = $crowdSourcingProjectManager;
        $this->questionnaireResponseManager = $questionnaireResponseManager;
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
     * @return \App\Models\User
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
        if ($numberOfResponseTransferred) {
            session()->flash('flash_message_success', 'Thanks for answering! ');
        }

        $url = session('redirectTo') ? session('redirectTo') : $this->redirectTo();

        return redirect($url);
    }
}
