<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectManager;
use App\BusinessLogicLayer\enums\CountryEnum;
use App\BusinessLogicLayer\enums\GenderEnum;
use App\BusinessLogicLayer\Questionnaire\QuestionnaireResponseManager;
use App\BusinessLogicLayer\User\UserManager;
use App\BusinessLogicLayer\User\UserRoleManager;
use App\Http\Controllers\Controller;
use App\Models\User\User;
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
    protected string $redirectTo = '/en/backoffice/my-dashboard';

    public function redirectTo(): string {
        return app()->getLocale() . '/backoffice/my-dashboard';
    }

    public function __construct(private UserRoleManager $userRoleManager,
        private UserManager $userManager,
        private MailChimpAdaptor $mailChimpManager,
        private CrowdSourcingProjectManager $crowdSourcingProjectManager,
        protected QuestionnaireResponseManager $questionnaireResponseManager) {
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
            'gender' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'year-of-birth' => 'nullable|integer|min:1920|max:' . (date('Y') - 18),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return User
     */
    protected function create(array $data) {
        $user = $this->userManager->createUser($data);
        $this->userRoleManager->assignRegisteredUserRoleTo($user);
        try {
            $user->notify(new UserRegistered);
        } catch (Exception $exception) {
            Log::error($exception);
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

    public function showRegistrationForm() {
        $availableGenders = GenderEnum::cases();

        $availableCountries = CountryEnum::cases();

        $availableYearsOfBirth = range(1920, (date('Y') - 18));

        $viewModel = [
            'availableGenders' => $availableGenders,
            'availableCountries' => $availableCountries,
            'availableYearsOfBirth' => $availableYearsOfBirth,
        ];

        return view('auth.register', ['viewModel' => $viewModel]);
    }
}
