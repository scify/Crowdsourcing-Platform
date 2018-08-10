<?php

namespace App\BusinessLogicLayer;

use App\DataAccessLayer\QuestionnaireStorageManager;
use App\Models\User;
use App\Models\ViewModels\DashboardInfo;
use App\Models\ViewModels\EditUser;
use App\Models\ViewModels\ManageUsers;
use App\Models\ViewModels\UserProfile;
use App\Repository\CrowdSourcingProjectRepository;
use App\Repository\UserRepository;
use App\Repository\UserRoleRepository;
use App\Utils\MailChimpAdaptor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserManager
{
    private $userRepository;
    private $userRoleRepository;
    private $questionnaireManager;
    private $projectRepository;
    private $mailChimpManager;
    public static $USERS_PER_PAGE = 10;

    public function __construct(UserRepository $userRepository,
                                UserRoleRepository $userRoleRepository,
                                QuestionnaireManager $questionnaireManager,
                                CrowdSourcingProjectRepository $projectRepository,
                                MailChimpAdaptor $mailChimpManager)
    {
        $this->userRepository = $userRepository;
        $this->userRoleRepository = $userRoleRepository;
        $this->questionnaireManager = $questionnaireManager;
        $this->projectRepository = $projectRepository;
        $this->mailChimpManager = $mailChimpManager;
    }

    function userIsPlatformAdmin($user)
    {
        return $this->userRepository->userIsPlatformAdmin($user);
    }

    public function getUserProfile($user)
    {
        return new UserProfile($user);
    }

    public function getDashboardData()
    {
        $projects = $this->projectRepository->getProjectWithStatusAndQuestionnaires();
        $responses = $this->questionnaireManager->getResponsesGivenByUserForProject(Auth::id(), 1); // TODO: use correct project id
        $badges = $this->calculateBadgesForLoggedInUser();
        return new DashboardInfo($projects, $responses, $badges);
    }

    public function getUser($userId)
    {
        return $this->userRepository->find($userId);
    }

    public function getManagePlatformUsersViewModel($paginationNumber, $filters = null)
    {
        $users = $this->userRepository->getPlatformUsers($paginationNumber, $filters, true);
        $allRoles = $this->userRoleRepository->getAllPlatformSpecificRoles();
        return new ManageUsers($users, $allRoles);
    }

    public function getEditUserViewModel($id)
    {
        $user = $this->userRepository->getUser($id);
        $userRoleIds = $user->roles->pluck('id');
        $allRoles = $this->userRoleRepository->getAllPlatformSpecificRoles();
        return new EditUser($user, $userRoleIds, $allRoles);
    }

    public function updateUserRoles($userId, $roleSelect)
    {
        $this->userRepository->updateUserRoles($userId, $roleSelect);
    }

    public function deactivateUser($id)
    {
        $user = $this->userRepository->getUserWithTrashed($id);
        $this->userRepository->softDeleteUser($user);
    }

    public function reactivateUser($id)
    {
        $user = $this->userRepository->getUserWithTrashed($id);
        $this->userRepository->reActivateUser($user);
    }

    public function getOrAddUserToPlatform($email, $nickname, $avatar, $password, $roleselect)
    {
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
            $this->userRepository->updateUserRoles($user->id, $roleselect);
            return new ActionResponse(UserActionResponses::USER_CREATED, $user);
        }
    }

    /**
     * @param $data array the form data array
     * @throws HttpException
     */
    public function updateUser($data)
    {
        $user_id = Auth::User()->id;
        $obj_user = User::find($user_id);
        $obj_user->nickname = $data['nickname'];
        $current_password = $obj_user->password;
        if ($data['password'] && $current_password != null) {
            if (Hash::check($data['current_password'], $current_password)) {
                $obj_user->password = Hash::make($data['password']);
            } else {
                throw new HttpException(500, "Current Password Incorrect.");
            }
        }
        $obj_user->save();
    }


    public function getPlatformAdminUsersWithCriteria($paginationNum = null, $data)
    {
        return $this->userRepository->getPlatformUsers($paginationNum, $data, true);
    }

    public function handleSocialLoginUser($socialUser)
    {

        $result = $this->getOrAddUserToPlatform($socialUser->email,
            $socialUser->name,
            $socialUser->avatar,
            null,
            [UserRoles::REGISTERED_USER]);
        // write user to 'Registered Users' newsletter if logins for the first time
        if ($result->status == UserActionResponses::USER_CREATED)
            $this->mailChimpManager->subscribe($socialUser->email, 'registered_users');
        if ($result->status == UserActionResponses::USER_CREATED || UserActionResponses::USER_UPDATED) {
            $user = $result->data;
            auth()->login($user);
            return $user;
        } else {
            throw new \Exception($result->status);
        }
    }

    public function createUser(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        return $this->userRepository->create($data);
    }

    private function generateContributorBadgeTooltipContent($questionnaireTitles)
    {
        $numberOfRespondedQuestionnaires = count($questionnaireTitles);
        $tooltipContentTemplate = '<p>You unlocked <b>{{0}}</b> badge because you responded 
                        to {{1}} questionnaire';
        $shouldAddListOfQuestionnaireTitles = false;
        if ($numberOfRespondedQuestionnaires === 1) {
            $temp = str_replace('{{0}}', 'Bronze Contributor (Level 1)', $tooltipContentTemplate);
            $temp = str_replace('{{1}}', 'your first', $temp);
            $temp = $temp . ' with title \'' . $questionnaireTitles[0] . '\'';
        } else if ($numberOfRespondedQuestionnaires === 2) {
            $temp = str_replace('{{0}}', 'Silver Contributor (Level 2)', $tooltipContentTemplate);
            $temp = str_replace('{{1}}', 'two', $temp);
            $temp = $temp . 's:';
            $shouldAddListOfQuestionnaireTitles = true;
        } else {
            $temp = str_replace('{{0}}', 'Gold Contributor (Level 3)', $tooltipContentTemplate);
            $temp = str_replace('{{1}}', 'six', $temp);
            $temp = $temp . 's:';
            $shouldAddListOfQuestionnaireTitles = true;
        }
        if ($shouldAddListOfQuestionnaireTitles) {
            $temp .= '<ul style=\'margin: 0; padding: 0;\'>{{2}}</ul>';
            $titlesNormalized = '';
            foreach ($questionnaireTitles as $title) {
                $titlesNormalized .= '<li style=\'margin: 0; padding: 0;\'>' . $title . '</li>';
            }
            $temp = str_replace('{{2}}', $titlesNormalized, $temp);
        }
        return $temp;
    }

    private function calculateBadgesForLoggedInUser()
    {
        // TODO: calculate badges for Influencers and Persuaders, as well
        $badges = [];
        $questionnairesTitles = [];
        $responses = $this->questionnaireManager->getResponsesGivenByUserForProject(Auth::id(), 1); // project 1 is 'Fair EU'
        foreach ($responses as $response) {
            array_push($questionnairesTitles, $response->title);
            switch (count($questionnairesTitles)) {
                case 1:
                    $tooltipContent = $this->generateContributorBadgeTooltipContent($questionnairesTitles);
                    array_push($badges, '<img class="gamification-badge bronze" 
                        src="' . asset('images/badges/contributor.png') . '" data-html="true" data-toggle="tooltip" 
                        title="' . $tooltipContent . '">'
                    );
                    break;
                case 2:
                    $tooltipContent = $this->generateContributorBadgeTooltipContent($questionnairesTitles);
                    array_push($badges, '<img class="gamification-badge silver" 
                        src="' . asset('images/badges/contributor.png') . '" data-html="true" data-toggle="tooltip" 
                        title="' . $tooltipContent . '">'
                    );
                    break;
                case 6:
                    $tooltipContent = $this->generateContributorBadgeTooltipContent($questionnairesTitles);
                    array_push($badges, '<img class="gamification-badge gold" 
                        src="' . asset('images/badges/contributor.png') . '" data-html="true" data-toggle="tooltip" 
                        title="' . $tooltipContent . '">'
                    );
                    break;
            }
        }
        return collect($badges);
    }
}
