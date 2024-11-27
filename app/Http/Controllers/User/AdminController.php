<?php

namespace App\Http\Controllers\User;

use App\BusinessLogicLayer\User\UserActionResponses;
use App\BusinessLogicLayer\User\UserManager;
use App\Http\Controllers\Controller;
use App\Utils\FileHandler;
use HttpException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
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
        $path = FileHandler::uploadAndGetPath($request->file('image'), 'solution_img');
        //        $fileObject = $request->file('image');
        //        $uploadedFile = UploadedFile::createFromBase($fileObject);
        //        $originalFileName = $uploadedFile->getClientOriginalName();
        //        $uniqueId = Str::uuid(); // Generate a unique ID for each file
        //        $path_s3 = Storage::disk('s3')->put('uploads/' . $uniqueId, $uploadedFile);
        //        $uploadedFilePath = Storage::disk('s3')->url($path_s3);

        return response()->json(['file_path_internal' => $path]);
    }
}
