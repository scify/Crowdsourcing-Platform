<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\questionnaire\QuestionnaireResponseManager;
use App\BusinessLogicLayer\UserDashboardManager;
use App\BusinessLogicLayer\UserManager;
use App\Http\OperationResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class UserController extends Controller {
    private UserManager $userManager;
    private QuestionnaireResponseManager $questionnaireResponseManager;
    protected UserDashboardManager $userDashboardManager;

    public function __construct(UserManager $userManager,
        QuestionnaireResponseManager $questionnaireResponseManager,
        UserDashboardManager $userDashboardManager) {
        $this->userManager = $userManager;
        $this->questionnaireResponseManager = $questionnaireResponseManager;
        $this->userDashboardManager = $userDashboardManager;
    }

    public function home() {
        return redirect('/' . app()->getLocale() . '/my-dashboard');
    }

    public function myDashboard() {
        $dashboardViewModel = $this->userDashboardManager->getUserDashboardViewModel(Auth::user());

        return view('loggedin-environment.my-dashboard', ['viewModel' => $dashboardViewModel]);
    }

    public function myAccount() {
        $userViewModel = $this->userManager->getUserProfile(Auth::user());

        return view('loggedin-environment.my-account', ['viewModel' => $userViewModel]);
    }

    public function patch(Request $request) {
        if ($request->password) {
            $this->validate($request, [
                'password' => 'sometimes|required_with:password_confirmation|confirmed|string|min:8|confirmed',
                'current_password' => 'sometimes|required_with:password|string|min:8',
            ]);
        }
        $data = $request->all();

        $this->userManager->updateUser($data);
        session()->flash('flash_message_success', 'Profile updated.');

        return back();
    }

    public function delete(Request $request) {
        $this->userManager->deactivateUser($request->id);
        session()->flash('flash_message_success', 'User deleted.');

        return back();
    }

    public function deactivateLoggedInUser() {
        $this->userManager->anonymizeUser(Auth::user());
        Auth::logout();

        return redirect()->route('home', ['locale' => app()->getLocale()]);
    }

    public function restore(Request $request) {
        $this->userManager->reactivateUser($request->id);
        session()->flash('flash_message_success', 'User restored.');

        return back();
    }

    public function showUsersByCriteria(Request $request) {
        $input = $request->all();
        $users = $this->userManager->getPlatformAdminUsersWithCriteria(UserManager::$USERS_PER_PAGE, $input);
        $users->setPath('#');
        if ($users->count() == 0) {
            $errorMessage = 'No Users found';

            return json_encode(new OperationResponse(config('app.OPERATION_FAIL'), (string) view('partials.ajax_error_message', compact('errorMessage'))));
        } else {
            return json_encode(new OperationResponse(config('app.OPERATION_SUCCESS'), (string) view('loggedin-environment.management.partials.users-list', compact('users'))));
        }
    }

    public function showUserContributions() {
        $responses = $this->questionnaireResponseManager->getQuestionnaireResponsesForUser(Auth::user());

        return view('loggedin-environment.my-history', ['responses' => $responses]);
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
        $columns = ['Project name', 'Questionnaire title', 'Questionnaire description', 'Questionnaire JSON', 'Response JSON'];

        $callback = function () use ($responses, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($responses as $response) {
                fputcsv($file, [$response->name, $response->title, $response->questionnaire_description, $response->questionnaire_json, $response->response_json]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
