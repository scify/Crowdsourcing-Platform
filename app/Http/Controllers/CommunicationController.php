<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 8/3/18
 * Time: 4:15 PM
 */

namespace App\Http\Controllers;

use App\BusinessLogicLayer\CommunicationManager;
use Illuminate\Http\Request;

class CommunicationController extends Controller {
    private $communicationManager;

    public function __construct(CommunicationManager $communicationManager) {
        $this->communicationManager = $communicationManager;
    }

    public function getMailChimpIntegration() {
        $viewModel = $this->communicationManager->getMailChimpIntegrationViewModel();

        return view('admin.mailchimp-integration')->with(['viewModel' => $viewModel]);
    }

    public function storeMailChimpListsIds(Request $request) {
        $this->validate($request, [
            'newsletter' => 'string|max:10',
            'registered_users' => 'required|string|max:10',
        ]);
        $this->communicationManager->storeMailChimpListIds(
            $request->newsletter,
            $request->registered_users
        );

        return redirect()->back()->with('flash_message_success', 'Lists IDs were successfully stored.');
    }

    public function signUpForNewsletter(Request $request) {
        $this->validate($request, [
            'first_name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
        ]);
        $this->communicationManager->signUpForNewsletter($request->first_name, $request->email);

        return response()->json(['status' => '__SUCCESS']);
    }
}
