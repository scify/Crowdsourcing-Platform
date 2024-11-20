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
use App\ViewModels\EditUser;
use App\ViewModels\ManageUsers;
use App\ViewModels\UserProfile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserManager {
    private UserRepository $userRepository;
    private UserRoleRepository $userRoleRepository;
    private MailChimpAdaptor $mailChimpManager;
    private QuestionnaireResponseRepository $questionnaireResponseRepository;
    private QuestionnaireAnswerVoteRepository $questionnaireAnswerVoteRepository;
    public static int $USERS_PER_PAGE = 10;
    public static string $USER_COOKIE_KEY = 'crowdsourcing_anonymous_user_id';

    public function __construct(UserRepository $userRepository,
        UserRoleRepository $userRoleRepository,
        MailChimpAdaptor $mailChimpManager,
        QuestionnaireResponseRepository $questionnaireResponseRepository,
        QuestionnaireAnswerVoteRepository $questionnaireAnswerVoteRepository) {
        $this->userRepository = $userRepository;
        $this->userRoleRepository = $userRoleRepository;
        $this->mailChimpManager = $mailChimpManager;
        $this->questionnaireResponseRepository = $questionnaireResponseRepository;
        $this->questionnaireAnswerVoteRepository = $questionnaireAnswerVoteRepository;
    }

    public function getUserProfile($user) {
        return new UserProfile($user);
    }

    public function getUser($userId) {
        return $this->userRepository->find($userId);
    }

    public function getManagePlatformUsersViewModel($paginationNumber, $filters = null) {
        $users = $this->userRepository->getPlatformUsers($paginationNumber, $filters, true);
        $allRoles = $this->userRoleRepository->getAllPlatformSpecificRoles();

        return new ManageUsers($users, $allRoles);
    }

    public function getEditUserViewModel($id) {
        $user = $this->userRepository->getUser($id);
        $userRoleIds = $user->roles->pluck('id');
        $allRoles = $this->userRoleRepository->getAllPlatformSpecificRoles();

        return new EditUser($user, $userRoleIds, $allRoles);
    }

    public function updateUserRoles($userId, $roleSelect) {
        $this->userRepository->updateUserRoles($userId, $roleSelect);
    }

    public function deactivateUser($id): void {
        $user = $this->userRepository->getUserWithTrashed($id);
        $this->questionnaireAnswerVoteRepository->deleteAnswerVotesByUser($user->id);
        $this->questionnaireResponseRepository->deleteResponsesByUser($user->id);
        $this->userRepository->softDeleteUser($user);
    }

    public function anonymizeAndDeleteUser($user): void {
        $this->questionnaireAnswerVoteRepository->deleteAnswerVotesByUser($user->id);
        $this->questionnaireResponseRepository->deleteResponsesByUser($user->id);
        $this->userRepository->anonymizeAndDeleteUser($user);
    }

    public function reactivateUser($id) {
        $user = $this->userRepository->getUserWithTrashed($id);
        $this->questionnaireAnswerVoteRepository->restoreAnswerVotesByUser($user->id);
        $this->questionnaireResponseRepository->restoreResponsesByUser($user->id);
        $this->userRepository->reActivateUser($user);
    }

    public function getOrAddUserToPlatform($email, $nickname, $avatar, $password, $roleselect): ActionResponse {
        $emailCheck = $this->userRepository->getUserByEmail($email);
        // Check if email exists in db
        if ($emailCheck) {
            // If email exists, update roles
            $this->userRepository->updateUserRoles($emailCheck->id, $roleselect);

            return new ActionResponse(UserActionResponses::USER_UPDATED, $emailCheck);
        } else {
            // If user email does not exist in db, notify for registration.
            $user = User::create([
                'nickname' => $nickname,
                'email' => $email,
                'avatar' => $avatar,
                'password' => $password != null ? bcrypt($password) : null,
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
            [UserRoles::REGISTERED_USER]);
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
        } else {
            throw new \Exception($result->status);
        }
    }

    public function createUser(array $data) {
        $data = [
            'email' => $data['email'],
            'nickname' => $data['nickname'],
            'password' => Hash::make($data['password']),
        ];
        if (!isset($_COOKIE[UserManager::$USER_COOKIE_KEY]) || !intval($_COOKIE[UserManager::$USER_COOKIE_KEY])) {
            return $this->userRepository->create($data);
        } else {
            $userId = intval($_COOKIE[UserManager::$USER_COOKIE_KEY]);
            try {
                $existingUser = $this->userRepository->find($userId);
                $this->userRepository->update([
                    'email' => $data['email'],
                    'nickname' => $data['nickname'],
                    'password' => $data['password'],
                ], $existingUser->id);

                return $this->userRepository->find($existingUser->id);
            } catch (ModelNotFoundException $e) {
                CookieManager::deleteCookie(UserManager::$USER_COOKIE_KEY);

                return $this->createUser($data);
            }
        }
    }

    public function userHasContributedToAProject($userId): bool {
        return $this->questionnaireResponseRepository->userResponseExists($userId);
    }

    public function getLoggedInUserOrCreateAnonymousUser() {
        if (Auth::check()) {
            return Auth::user();
        }
        if (isset($_COOKIE[UserManager::$USER_COOKIE_KEY]) && intval($_COOKIE[UserManager::$USER_COOKIE_KEY])) {
            try {
                return $this->userRepository->find(intval($_COOKIE[UserManager::$USER_COOKIE_KEY]));
            } catch (ModelNotFoundException $e) {
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
