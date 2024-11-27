<?php

namespace App\Http\Controllers\User;

use App\BusinessLogicLayer\User\UserActionResponses;
use App\BusinessLogicLayer\User\UserManager;
use App\Http\Controllers\Controller;
use App\Utils\FileHandler;
use HttpException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller {
    private $userManager;

    public function __construct(UserManager $userManager) {
        $this->userManager = $userManager;
    }

    public function manageUsers() {
        $viewModel = $this->userManager->getManagePlatformUsersViewModel(UserManager::$USERS_PER_PAGE);

        return view('backoffice.management.manage-users', ['viewModel' => $viewModel]);
    }

    public function editUserForm(Request $request) {
        $viewModel = $this->userManager->getEditUserViewModel($request->id);

        return view('backoffice.management.edit-user', ['viewModel' => $viewModel]);
    }

    public function updateUserRoles(Request $request) {
        $this->userManager->updateUserRoles($request->userId, $request->roleselect);

        return redirect()->back()->with(['flash_message_success' => 'User roles have been updated.']);
    }

    public function addUserToPlatform(Request $request) {
        $result = $this->userManager->getOrAddUserToPlatform($request->email,
            $request->nickname,
            null,
            $request->password,
            [$request->roleselect]);
        switch ($result->status) {
            case UserActionResponses::USER_UPDATED:
                session()->flash('flash_message_success', 'User exists in platform. Their roles were updated.');
                break;
            case UserActionResponses::USER_CREATED:
                session()->flash('flash_message_success', 'User has been added to the platform.');
                break;
            default:
                throw new HttpException('Not a valid request');
        }

        return back();
    }

    public function checkUploadPage() {
        return view('backoffice.admin.check-upload');
    }

    public function uploadAdminFile(Request $request) {
        $request->validate([
            'image' => 'required|file|image', // Validate the file input
        ]);

        $fileObject = $request->file('image');

        if (!$fileObject->isValid()) {
            return response()->json(['error' => 'Invalid file upload.'], 400);
        }

        $originalFileName = $fileObject->getClientOriginalName();
        $uniqueId = Str::uuid(); // Generate a unique ID for each file

        // Store the file in S3
        $path_s3 = Storage::disk('s3')->put('uploads/' . $uniqueId, $fileObject);
        $uploadedFilePathS3 = Storage::disk('s3')->url($path_s3);

        // also store the file in the local storage (storage/app/public/uploads/solution_img)
        $path = FileHandler::uploadAndGetPath($fileObject, 'solution_img');

        return response()->json(['file_path_s3' => $uploadedFilePathS3, 'original_file_name' => $originalFileName, 'file_path_local' => $path]);
    }
}
