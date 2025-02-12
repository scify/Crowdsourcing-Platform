<?php

namespace App\BusinessLogicLayer\User;

use App\BusinessLogicLayer\ActionResponse;
use App\BusinessLogicLayer\CookieManager;
use App\Models\User\User;
use App\Notifications\UserRegistered;
use App\Repository\Questionnaire\Responses\QuestionnaireAnswerVoteRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use App\Repository\User\UserRepository;
use App\Repository\User\UserRoleRepository;
use App\Utils\FileHandler;
use App\Utils\MailChimpAdaptor;
use App\ViewModels\User\EditUser;
use App\ViewModels\User\ManageUsers;
use App\ViewModels\User\UserProfile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserManager {
    public static int $USERS_PER_PAGE = 10;
    public static string $USER_COOKIE_KEY = 'crowdsourcing_anonymous_user_id';

    public function __construct(private readonly UserRepository $userRepository, private readonly UserRoleRepository $userRoleRepository, private readonly MailChimpAdaptor $mailChimpManager, private readonly QuestionnaireResponseRepository $questionnaireResponseRepository, private readonly QuestionnaireAnswerVoteRepository $questionnaireAnswerVoteRepository) {}

    public function getUserProfile($user): UserProfile {
        return new UserProfile($user);
    }

    public function getUser($userId) {
        return $this->userRepository->find($userId);
    }

    public function getManagePlatformUsersViewModel($paginationNumber, $filters = null): ManageUsers {
        $users = $this->userRepository->getPlatformUsers($paginationNumber, $filters);
        $allRoles = $this->userRoleRepository->getAllPlatformSpecificRoles();

        return new ManageUsers($users, $allRoles);
    }

    public function getEditUserViewModel($id): EditUser {
        $user = $this->userRepository->getUser($id);
        $userRoleIds = $user->roles->pluck('id');
        $allRoles = $this->userRoleRepository->getAllPlatformSpecificRoles();

        return new EditUser($user, $userRoleIds, $allRoles);
    }

    public function updateUserRoles($userId, array $roleSelect): void {
        $this->userRepository->updateUserRoles($userId, $roleSelect);
    }

    public function deactivateUser($id): void {
        $user = $this->userRepository->getUserWithTrashed($id);
        $this->questionnaireAnswerVoteRepository->deleteAnswerVotesByUser($user->id);
        $this->questionnaireResponseRepository->deleteResponsesByUser($user->id);
        $this->userRepository->softDeleteUser($user);
    }

    public function anonymizeAndDeleteUser(User $user): void {
        $this->questionnaireAnswerVoteRepository->deleteAnswerVotesByUser($user->id);
        $this->questionnaireResponseRepository->deleteResponsesByUser($user->id);
        $this->userRepository->anonymizeAndDeleteUser($user);
    }

    public function reactivateUser($id): void {
        $user = $this->userRepository->getUserWithTrashed($id);
        $this->questionnaireAnswerVoteRepository->restoreAnswerVotesByUser($user->id);
        $this->questionnaireResponseRepository->restoreResponsesByUser($user->id);
        $this->userRepository->reActivateUser($user);
    }

    public function getOrAddUserToPlatform($email, $nickname, $avatar, $password, array $roleselect, $gender, $country, $year_of_birth): ActionResponse {
        $user = $this->userRepository->getUserByEmail($email);
        // Check if email exists in db
        if ($user) {
            // If email exists, update roles
            $this->userRepository->updateUserRoles($user->id, $roleselect);

            $user->nickname = $nickname;
            $user->avatar = $avatar;
            if ($user->password != null) {
                bcrypt($password);
            }
            $user->gender = $gender;
            $user->country = $country;
            $user->year_of_birth = $year_of_birth;

            $user->save();

            return new ActionResponse(UserActionResponses::USER_UPDATED, $user);
        }
        // If user email does not exist in db, notify for registration.
        $user = User::create([
            'nickname' => $nickname,
            'email' => $email,
            'avatar' => $avatar,
            'password' => $password != null ? bcrypt($password) : null,
            'gender' => $gender,
            'country' => $country,
            'year_of_birth' => $year_of_birth,
        ]);
        $user->save();
        try {
            $user->notify(new UserRegistered);
        } catch (\Exception $e) {
            Log::error($e);
        }
        $this->userRepository->updateUserRoles($user->id, $roleselect);

        return new ActionResponse(UserActionResponses::USER_CREATED, $user);
    }

    /**
     * @param $data array the form data array
     *
     * @throws HttpException
     */
    public function updateUser(array $data): bool {
        $user = Auth::user();
        $user->nickname = $data['nickname'];
        $user->email = $data['email'];
        $user->gender = $data['gender'];
        $user->country = $data['country'];
        $user->year_of_birth = $data['year-of-birth'];

        if (isset($data['password']) && $data['password'] != null) {
            $current_password = $user->password;
            if (Hash::check($data['current_password'], $current_password)) {
                $user->password = Hash::make($data['password']);
            } else {
                throw new HttpException(500, 'Current Password Incorrect.');
            }
        }

        if (isset($data['avatar']) && $data['avatar']->isValid()) {
            $path = FileHandler::uploadAndGetPath($data['avatar'], 'user_profile_img');
            $user->avatar = $path;
        }

        return $user->save();
    }

    public function updateUserById(int $userId, array $data): bool {
        $user = $this->userRepository->find($userId);
        $user->nickname = $data['nickname'];
        $user->email = $data['email'];
        $user->gender = $data['gender'];
        $user->country = $data['country'];
        $user->year_of_birth = $data['year-of-birth'];

        return $user->save();
    }

    public function getPlatformAdminUsersWithCriteria($paginationNum, $data = []) {
        return $this->userRepository->getPlatformUsers($paginationNum, $data);
    }

    /**
     * @throws \Exception
     */
    public function handleSocialLoginUser($socialUser) {
        // Facebook might not return email (if the user has signed up using phone for example).
        // In that case, we should use another field that is always present.
        $registerToMailchimp = true;
        if (!$socialUser->email) {
            $socialUser->email = $socialUser->id . '@dummy.crowdsourcing.org';
            $registerToMailchimp = false;
        }

        $result = $this->getOrAddUserToPlatform($socialUser->email,
            $socialUser->name,
            $socialUser->avatar,
            null,
            [UserRoles::REGISTERED_USER],
            null,
            null,
            null);
        // write user to 'Registered Users' newsletter if logins for the first time
        if ($registerToMailchimp &&
            $result->status == UserActionResponses::USER_CREATED && config('app.mailchimp_api_key') !== ''
            && config('app.mailchimp_api_key') !== null) {
            $this->mailChimpManager->subscribe($socialUser->email, 'registered_users', $socialUser->name);
        }
        if ($result->status == UserActionResponses::USER_CREATED || UserActionResponses::USER_UPDATED) {
            $user = $result->data;
            auth()->login($user);

            return $user;
        }
        throw new \Exception($result->status);
    }

    public function createUser(array $input_data) {
        $user_data = [
            'email' => $input_data['email'],
            'nickname' => $input_data['nickname'],
            'password' => $input_data['password'],
            'gender' => $input_data['gender'],
            'country' => $input_data['country'],
            'year-of-birth' => $input_data['year-of-birth'],
        ];
        $user_id = intval(CookieManager::getCookie(UserManager::$USER_COOKIE_KEY));
        if ($user_id === 0) {
            return $this->userRepository->create($user_data);
        }
        try {
            $existingUser = $this->userRepository->find($user_id);
            $this->userRepository->update([
                'email' => $user_data['email'],
                'nickname' => $user_data['nickname'],
                'password' => bcrypt($input_data['password']),
                'gender' => $user_data['gender'],
                'country' => $user_data['country'],
                'year_of_birth' => $user_data['year-of-birth'],
            ], $existingUser->id);

            return $this->userRepository->find($existingUser->id);
        } catch (ModelNotFoundException) {
            CookieManager::deleteCookie(UserManager::$USER_COOKIE_KEY);

            return $this->createUser($user_data);
        }
    }

    public function getLoggedInUserOrCreateAnonymousUser() {
        if (Auth::check()) {
            return Auth::user();
        }
        $user_id = intval(CookieManager::getCookie(UserManager::$USER_COOKIE_KEY));
        if ($user_id !== 0) {
            try {
                return $this->userRepository->find($user_id);
            } catch (ModelNotFoundException) {
                return $this->createAnonymousUser();
            }
        }

        return $this->createAnonymousUser();
    }

    protected function createAnonymousUser(): User {
        $name = 'Anonymous_User_' . now()->timestamp;

        return $this->userRepository->create([
            'nickname' => $name,
            'email' => $name . '@crowd.org',
        ]);
    }
}
