<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\CommunicationManager;
use Illuminate\Http\Request;

class CommunicationController extends Controller {
    public function __construct(private readonly CommunicationManager $communicationManager) {}

    public function getMailChimpIntegration() {
        $viewModel = $this->communicationManager->getMailChimpIntegrationViewModel();

        return view('backoffice.management.mailchimp-integration')->with(['viewModel' => $viewModel]);
    }

    public function storeMailChimpListsIds(Request $request) {
        $this->validate($request, [
            'newsletter' => 'string|max:10',
            'registered_users' => 'required|string|max:10',
        ]);
        $this->communicationManager->storeMailChimpListIds(
            $request->registered_users
        );

        return redirect()->back()->with('flash_message_success', 'Lists IDs were successfully stored.');
    }
}
