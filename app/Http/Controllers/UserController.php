<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\QuestionnaireResponseManager;
use App\BusinessLogicLayer\UserManager;
use App\Http\OperationResponse;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    private $userManager;
    private $questionnaireResponseManager;

    public function __construct(UserManager $userManager, QuestionnaireResponseManager $questionnaireResponseManager)
    {
        $this->userManager = $userManager;
        $this->questionnaireResponseManager = $questionnaireResponseManager;
    }

    public function home()
    {
        return redirect('/my-dashboard');
    }

    public function myDashboard()
    {
        $dashboardViewModel = $this->userManager->getDashboardViewModel();
        return view('my-dashboard', ['viewModel' => $dashboardViewModel]);
    }

    public function myAccount()
    {
        $userViewModel = $this->userManager->getUserProfile(Auth::user());
        return view('my-account', ['viewModel' => $userViewModel]);
    }

    public function patch(Request $request) {
        if ($request->password)
            $this->validate($request, [
                'password' => 'required|string|min:6|confirmed',
                'current_password' => 'sometimes|required|string|min:6'
            ]);
        $data = $request->all();

        $this->userManager->updateUser($data);
        session()->flash('flash_message_success', 'Profile updated.');
        return back();
    }

    public function delete(Request $request)
    {
        $this->userManager->deactivateUser($request->id);
        session()->flash('flash_message_success', 'User deleted.');
        return back();
    }

    public function deactivateLoggedInUser() {
        $this->userManager->anonymizeUser(Auth::user());
        Auth::logout();
        return redirect()->route('home');
    }

    public function restore(Request $request)
    {
        $this->userManager->reactivateUser($request->id);
        session()->flash('flash_message_success', 'User restored.');
        return back();
    }

    public function showUsersByCriteria(Request $request)
    {
        $input = $request->all();
        $users = $this->userManager->getPlatformAdminUsersWithCriteria(UserManager::$USERS_PER_PAGE, $input);
        $users->setPath('#');
        if ($users->count() == 0) {
            $errorMessage = "No Users found";
            return json_encode(new OperationResponse(config('app.OPERATION_FAIL'), (String)view('partials.ajax_error_message', compact('errorMessage'))));
        } else {
            return json_encode(new OperationResponse(config('app.OPERATION_SUCCESS'), (String)view('admin.partials.users-list', compact('users'))));
        }
    }

    public function showUserHistory() {
        $responses = $this->questionnaireResponseManager->getQuestionnaireResponsesForUser(Auth::user());
        return view('my-history', ['responses' => $responses]);
    }

    public function downloadUserData() {
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=file" . time() .".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $responses = $this->questionnaireResponseManager->getQuestionnaireResponsesForUser(Auth::user());
        $columns = array('Project name', 'Questionnaire title', 'Questionnaire description', 'Questionnaire JSON', 'Response JSON');

        $callback = function() use ($responses, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($responses as $response) {
                fputcsv($file, array($response->name, $response->title, $response->questionnaire_description, $response->questionnaire_json, $response->response_json));
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }
}