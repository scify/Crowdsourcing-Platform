<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\BusinessLogicLayer\enums\CountryEnum;
use App\BusinessLogicLayer\enums\GenderEnum;
use App\BusinessLogicLayer\User\UserActionResponses;
use App\BusinessLogicLayer\User\UserManager;
use App\Http\Controllers\Controller;
use App\Utils\FileHandler;
use HttpException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller {
    public function __construct(private readonly \App\BusinessLogicLayer\User\UserManager $userManager) {}

    public function manageUsers(): View|Factory {
        $manageUsers = $this->userManager->getManagePlatformUsersViewModel(UserManager::$USERS_PER_PAGE);

        $availableGenders = GenderEnum::cases();
        $manageUsers->availableGenders = $availableGenders;

        $availableCountries = CountryEnum::cases();
        $manageUsers->availableCountries = $availableCountries;

        $availableYearsOfBirth = range(1920, (date('Y') - 18));
        $manageUsers->availableYearsOfBirth = $availableYearsOfBirth;

        return view('backoffice.management.manage-users', ['viewModel' => $manageUsers]);
    }

    public function editUserForm(Request $request): View|Factory {
        $editUser = $this->userManager->getEditUserViewModel($request->id);

        $availableGenders = GenderEnum::cases();
        $editUser->availableGenders = $availableGenders;

        $availableCountries = CountryEnum::cases();
        $editUser->availableCountries = $availableCountries;

        $availableYearsOfBirth = range(1920, (date('Y') - 18));
        $editUser->availableYearsOfBirth = $availableYearsOfBirth;

        return view('backoffice.management.edit-user', ['viewModel' => $editUser]);
    }

    public function updateUserRoles(Request $request) {
        $this->userManager->updateUserById($request->userId, $request->all());
        $this->userManager->updateUserRoles($request->userId, $request->roleselect);

        return redirect()->back()->with(['flash_message_success' => 'User roles have been updated.']);
    }

    public function addUserToPlatform(Request $request): \Illuminate\Http\RedirectResponse {
        $actionResponse = $this->userManager->getOrAddUserToPlatform($request->email,
            $request->nickname,
            null,
            $request->password,
            [$request->roleselect],
            $request->gender,
            $request->country,
            $request['year-of-birth']);
        match ($actionResponse->status) {
            UserActionResponses::USER_UPDATED => session()->flash('flash_message_success', 'User exists in platform. Their roles were updated.'),
            UserActionResponses::USER_CREATED => session()->flash('flash_message_success', 'User has been added to the platform.'),
            default => throw new HttpException('Not a valid request'),
        };

        return back();
    }

    public function checkUploadPage(): View|Factory {
        return view('backoffice.admin.check-upload');
    }

    public function uploadAdminFile(Request $request) {
        $request->validate([
            'image' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $fileObject = $request->file('image');

        if (! $fileObject->isValid()) {
            return response()->json(['error' => 'Invalid file upload.'], 400);
        }

        $originalFileName = $fileObject->getClientOriginalName();
        $uuid = Str::uuid(); // Generate a unique ID for each file

        // Store the file in S3
        $path_s3 = Storage::disk('s3')->put('uploads/' . $uuid, $fileObject);
        $uploadedFilePathS3 = Storage::disk('s3')->url($path_s3);

        // also store the file in the local storage (storage/app/public/uploads/solution_img)
        $path = FileHandler::uploadAndGetPath($fileObject, 'solution_img');

        return response()->json(['file_path_s3' => $uploadedFilePathS3, 'original_file_name' => $originalFileName, 'file_path_local' => $path]);
    }
}
