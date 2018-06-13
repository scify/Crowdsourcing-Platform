<?php

namespace App\BusinessLogicLayer;

use App\Models\CMS;
use App\Models\User;
use App\Models\ViewModels\UserProfile;
use App\Repository\UserRepository;
use Auth;
use Exception;
use Gate;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class UserManager
{
    private $userRepository;
    private $onlineStoreManager;

    /**
     * UserManager constructor.
     * @param $userRepository
     */
    public function __construct(UserRepository $userRepository,
                                OnlineStoreManager $onlineStoreManager
    )
    {
        $this->userRepository = $userRepository;
        $this->onlineStoreManager= $onlineStoreManager;
    }



    function userIsPlatformAdmin($user)
    {
        return $this->userRepository->userIsPlatformAdmin($user);
    }

    public function updateLocation($user, $location_name, $lat, $lon)
    {
        $this->userRepository->updateLocation($user, $location_name, $lat, $lon);
    }

    public function getMyProfileData($user)
    {
        $articles = $user->articles()->whereNull("parent_article_id");


        $storeInfo  = $this->onlineStoreManager->getOnlineStoreStatsForUserPurchases($user);

        $totalArticlesBought = $this->onlineStoreManager->getNumberArticlesUserHasPurchased($user);
        return new UserProfile($user,
            $articles,
            $storeInfo->totalArticlesOnStore,
            $storeInfo->totalEarningsFromStore,
            $totalArticlesBought );

    }

    public function getUser($userId) {
        return $this->userRepository->find($userId);
    }

    public function getAllPublishers() {
        return $this->userRepository->getAllUsersWithRole(PermissionsManager::PUBLISHER);
    }
}
