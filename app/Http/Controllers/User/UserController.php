<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\BusinessLogicLayer\enums\CountryEnum;
use App\BusinessLogicLayer\enums\GenderEnum;
use App\BusinessLogicLayer\Questionnaire\QuestionnaireResponseManager;
use App\BusinessLogicLayer\Solution\SolutionManager;
use App\BusinessLogicLayer\User\UserDashboardManager;
use App\BusinessLogicLayer\User\UserManager;
use App\Http\Controllers\Controller;
use App\Http\OperationResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class UserController extends Controller {
    public function __construct(private readonly UserManager $userManager, private readonly QuestionnaireResponseManager $questionnaireResponseManager, protected UserDashboardManager $userDashboardManager, protected SolutionManager $solutionManager) {}

    public function home() {
        return redirect()->route('my-dashboard', ['locale' => app()->getLocale()]);
    }

    public function myDashboard() {
        $dashboardViewModel = $this->userDashboardManager->getUserDashboardViewModel(Auth::user());

        return view('backoffice.my-dashboard', ['viewModel' => $dashboardViewModel]);
    }

    public function myAccount() {
        $viewModel = $this->userManager->getUserProfile(Auth::user());

        $availableGenders = GenderEnum::cases();
        $viewModel->availableGenders = $availableGenders;

        $availableCountries = CountryEnum::cases();
        $viewModel->availableCountries = $availableCountries;

        $availableYearsOfBirth = range(1920, (date('Y') - 18));
        $viewModel->availableYearsOfBirth = $availableYearsOfBirth;

        return view('backoffice.my-account', ['viewModel' => $viewModel]);
    }

    public function patch(Request $request) {
        $validationArray = [
            'nickname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gender' => 'required|nullable|string|max:255',
            'country' => 'required|nullable|string|max:255',
            'year-of-birth' => 'required|nullable|integer|min:1920|max:' . (date('Y') - 18),
        ];
        if ($request->password) {
            $validationArray['password'] = 'required_with:password_confirmation|string|min:8|confirmed';
            $validationArray['current_password'] = 'required|string|min:8';
        }

        // here we need to add custom messages for the validation, since the field is called 'avatar' and not 'profile image'.
        $customMessages = [
            'avatar.image' => __('validation.image', ['attribute' => __('my-account.profile_image')]),
            'avatar.mimes' => __('validation.mimes', ['attribute' => __('my-account.profile_image'), 'values' => 'jpeg, png, jpg']),
            'avatar.max' => __('validation.max.file', ['attribute' => __('my-account.profile_image'), 'max' => '2']),
        ];
        $customAttributes = [
            'avatar' => 'profile image',
        ];
        $this->validate($request, $validationArray, $customMessages, $customAttributes);
        $data = $request->all();
        try {
            $this->userManager->updateUser($data);
            session()->flash('flash_message_success', 'Profile updated.');

            return back();
        } catch (\Exception $exception) {
            session()->flash('flash_message_error', 'Error: ' . $exception->getCode() . '  ' . $exception->getMessage());

            return back()->withInput();
        }
    }

    public function delete(Request $request) {
        $this->userManager->deactivateUser(intval($request->id));
        session()->flash('flash_message_success', 'User deleted.');

        return back();
    }

    public function deactivateLoggedInUser() {
        $this->userManager->anonymizeAndDeleteUser(Auth::user());
        Auth::logout();

        return redirect()->route('home', ['locale' => app()->getLocale()]);
    }

    public function restore(Request $request) {
        $this->userManager->reactivateUser(intval($request->id));
        session()->flash('flash_message_success', 'User restored.');

        return back();
    }

    public function showUsersByCriteria(Request $request) {
        $input = $request->all();
        $users = $this->userManager->getPlatformAdminUsersWithCriteria(UserManager::$USERS_PER_PAGE, $input);
        $users->setPath('#');
        if ($users->count() == 0) {
            $errorMessage = 'No Users found';

            return json_encode(new OperationResponse(config('app.OPERATION_FAIL'), (string) view('partials.ajax_error_message', ['errorMessage' => $errorMessage])));
        }

        return json_encode(new OperationResponse(config('app.OPERATION_SUCCESS'), (string) view('backoffice.management.partials.users-list', ['users' => $users])));
    }

    public function showUserContributions() {
        $user = Auth::user();
        $responses = $this->questionnaireResponseManager->getQuestionnaireResponsesForUser($user);
        $solutions = $this->solutionManager->getSolutionsProposedByUser($user);

        return view('backoffice.my-contributions', ['responses' => $responses, 'solutions' => $solutions]);
    }

    public function downloadMyData() {
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=file' . time() . '.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $responses = $this->questionnaireResponseManager->getQuestionnaireResponsesForUser(Auth::user());
        $solutions = $this->solutionManager->getSolutionsProposedByUser(Auth::user());
        $columns = ['Type', 'Project name', 'Title', 'Description', 'JSON'];

        $callback = function () use ($responses, $solutions, $columns): void {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($responses as $response) {
                fputcsv($file, ['Response', $response->project_name, $response->title, $response->questionnaire_description, $response->response_json]);
            }

            foreach ($solutions as $solution) {
                fputcsv($file, ['Solution', $solution->problem->project->defaultTranslation->name, $solution->defaultTranslation->title, $solution->defaultTranslation->description, '']);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
