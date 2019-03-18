<?php

namespace App\BusinessLogicLayer;

use App\BusinessLogicLayer\gamification\GamificationManager;
use App\Models\User;
use App\Models\ViewModels\DashboardInfo;
use App\Models\ViewModels\EditUser;
use App\Models\ViewModels\ManageUsers;
use App\Models\ViewModels\UserProfile;
use App\Notifications\UserRegistered;
use App\Repository\CrowdSourcingProjectRepository;
use App\Repository\UserRepository;
use App\Repository\UserRoleRepository;
use App\Utils\MailChimpAdaptor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserManager {
    private $userRepository;
    private $userRoleRepository;
    private $questionnaireManager;
    private $projectRepository;
    private $mailChimpManager;
    private $gamificationManager;
    private $crowdSourcingProjectManager;
    private $webSessionManager;
    private $questionnaireResponseManager;
    public static $USERS_PER_PAGE = 10;

    public function __construct(UserRepository $userRepository,
                                UserRoleRepository $userRoleRepository,
                                QuestionnaireManager $questionnaireManager,
                                QuestionnaireResponseManager $questionnaireResponseManager,
                                CrowdSourcingProjectRepository $projectRepository,
                                CrowdSourcingProjectManager $crowdSourcingProjectManager,
                                MailChimpAdaptor $mailChimpManager,
                                GamificationManager $gamificationManager,
                                WebSessionManager $webSessionManager) {
        $this->userRepository = $userRepository;
        $this->userRoleRepository = $userRoleRepository;
        $this->questionnaireManager = $questionnaireManager;
        $this->projectRepository = $projectRepository;
        $this->mailChimpManager = $mailChimpManager;
        $this->gamificationManager = $gamificationManager;
        $this->crowdSourcingProjectManager = $crowdSourcingProjectManager;
        $this->webSessionManager = $webSessionManager;
        $this->questionnaireResponseManager = $questionnaireResponseManager;
    }

    function userIsPlatformAdmin($user) {
        return $this->userRepository->userIsPlatformAdmin($user);
    }

    public function getUserProfile($user) {
        return new UserProfile($user);
    }

    public function getDashboardViewModel() {
        $project = $this->crowdSourcingProjectManager->getDefaultCrowdsourcingProject();
        $gamificationBadgesForUser = $this->gamificationManager->getGamificationBadgesForUser(Auth::id());
        $gamificationBadgesViewModel = $this->gamificationManager->getGamificationBadgesViewModels($gamificationBadgesForUser);
        $gamificationNextStepViewModel = $this->gamificationManager->getGamificationNextStepViewModel($gamificationBadgesForUser);
        $projectGoalVM = $this->crowdSourcingProjectManager->getCrowdSourcingProjectGoalViewModel($project->id);
        return new DashboardInfo($project, $gamificationBadgesViewModel, $gamificationNextStepViewModel, $projectGoalVM);
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

    public function deactivateUser($id) {
        $user = $this->userRepository->getUserWithTrashed($id);
        $this->userRepository->softDeleteUser($user);
    }

    public function anonymizeUser($user) {
        $this->userRepository->anonymizeUser($user);
    }

    public function reactivateUser($id) {
        $user = $this->userRepository->getUserWithTrashed($id);
        $this->userRepository->reActivateUser($user);
    }

    public function getOrAddUserToPlatform($email, $nickname, $avatar, $password, $roleselect) {
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
                $user->notify(new UserRegistered($this->crowdSourcingProjectManager));
            } catch (\Exception $e) {
                Log::error($e);
            }
            $this->userRepository->updateUserRoles($user->id, $roleselect);
            return new ActionResponse(UserActionResponses::USER_CREATED, $user);
        }
    }

    /**
     * @param $data array the form data array
     * @throws HttpException
     */
    public function updateUser($data) {
        $user_id = Auth::User()->id;
        $obj_user = User::find($user_id);
        $obj_user->nickname = $data['nickname'];
        $current_password = $obj_user->password;
        if (!$current_password) {
            $obj_user->password = Hash::make($data['password']);
        } else {
            if (Hash::check($data['current_password'], $current_password)) {
                $obj_user->password = Hash::make($data['password']);
            } else {
                throw new HttpException(500, "Current Password Incorrect.");
            }
        }

        $obj_user->save();
    }


    public function getPlatformAdminUsersWithCriteria($paginationNum = null, $data) {
        return $this->userRepository->getPlatformUsers($paginationNum, $data, true);
    }

    public function handleSocialLoginUser($socialUser) {

        $result = $this->getOrAddUserToPlatform($socialUser->email,
            $socialUser->name,
            $socialUser->avatar,
            null,
            [UserRoles::REGISTERED_USER]);
        // write user to 'Registered Users' newsletter if logins for the first time
        if ($result->status == UserActionResponses::USER_CREATED)
            $this->mailChimpManager->subscribe($socialUser->email, 'registered_users', $socialUser->name);
        if ($result->status == UserActionResponses::USER_CREATED || UserActionResponses::USER_UPDATED) {
            $user = $result->data;
            auth()->login($user);
            return $user;
        } else {
            throw new \Exception($result->status);
        }
    }

    public function createUser(array $data) {
        $data['password'] = bcrypt($data['password']);
        return $this->userRepository->create($data);
    }

    public function setReferrerIdToWebSession($referrerId) {
        $referrer = $this->getUser($referrerId);
        if ($referrer)
            $this->webSessionManager->setReferrerId($referrerId);
    }

    public function userHasContributedToAProject($userId) {
        return $this->questionnaireResponseManager->questionnaireResponsesForUserExists($userId);
    }
}
