<?php

namespace App\Models\ViewModels;

use App\BusinessLogicLayer\ArticleStatuses;
use Illuminate\Support\Collection;

class ArticleCreateEdit
{

    private $article;
    private $statuses;
    private $categories;
    private $defaultCategories;
    private $user;
    private $cms;
    private $cmsToSendACopyOfTheArticle;
    private $cmsIdsListArticleHasAlreadyBeenSent;
    private $tags;
    private $articleCategoriesIds;
    private $articleTagsIds;
    private $articleCategories;
    private $articleTags;
    private $cmsListUserIsAssociatedWith;
    private $pixelatedImagePath;
    private $totalPeopleRespondedInRequests;
    private $articleStoreInfo;
    private $displayStatus;
    private $articlesUserHasSentToPublishers;
    private $articleIsAProductOfPurchaseFromStore;

    /**
     * ArticleCreateEdit constructor.
     * @param $user
     * @param $article
     * @param $statuses
     * @param $categories
     * @param $defaultCategories array News central categories
     * @param $cms
     * @param $cmsToSendACopyOfTheArticle
     * @param $cmsIdsListArticleHasAlreadyBeenSent
     * @param $tags
     * @param $cmsListUserIsAssociatedWith A list of CMS user has the ability to publish directly, without sending a copy
     * @param $pixelatedImagePath
     * @param $articleStoreInfo
     * @param $displayStatus
     * @param $articlesUserHasSentToPublishers
     * @param $articleIsAProductOfPurchaseFromStore
     */
    public function __construct($user,
                                $article,
                                $statuses,
                                $categories,
                                $defaultCategories,
                                $cms,
                                $cmsToSendACopyOfTheArticle,
                                $cmsIdsListArticleHasAlreadyBeenSent,
                                $tags,
                                $cmsListUserIsAssociatedWith,
                                $pixelatedImagePath,
                                $articleStoreInfo,
                                $displayStatus,
                                $articlesUserHasSentToPublishers,
                                $articleIsAProductOfPurchaseFromStore)
    {
        $this->user = $user;
        $this->article = $article;
        $this->articleCategories = $article->categories;
        $this->articleTags = $article->tags;
        $this->statuses = $statuses;
        $this->categories = $categories;
        $this->defaultCategories = $defaultCategories;
        $this->cms = $cms;
        $this->cmsToSendACopyOfTheArticle = $cmsToSendACopyOfTheArticle;
        $this->cmsIdsListArticleHasAlreadyBeenSent = $cmsIdsListArticleHasAlreadyBeenSent;
        $this->tags = $tags;
        $this->articleCategoriesIds = $this->articleCategories->pluck("id")->toArray();
        $this->articleTagsIds = $this->articleTags->pluck("id")->toArray();
        $this->cmsListUserIsAssociatedWith = $cmsListUserIsAssociatedWith;
        $this->pixelatedImagePath = $pixelatedImagePath;
        $this->totalPeopleRespondedInRequests = $this->getTotalPeopleResponded($article);
        $this->articleStoreInfo = $articleStoreInfo;
        $this->displayStatus = $displayStatus;
        $this->articlesUserHasSentToPublishers = new Collection();
        if ($articlesUserHasSentToPublishers !=null){
            foreach ($articlesUserHasSentToPublishers as $temp) {
                $statusCssName = $this->getArticleStatusCSSName($temp->status_id);
                $temp->status_css_name = $statusCssName;
                $this->articlesUserHasSentToPublishers->push($temp);
            }
        }
        $this->articleIsAProductOfPurchaseFromStore = $articleIsAProductOfPurchaseFromStore;
    }

    public function displayStatus()
    {
        return $this->displayStatus;
    }

    public function getArticleStoreInfo()
    {
        return $this->articleStoreInfo;
    }

    public function userCanCreateArticlesDirectlyForPublishers()
    {
        return !$this->cmsListUserIsAssociatedWith->isEmpty();
    }

    public function getCMSThisArticleCanBeAssociatedAt()
    {
        return $this->cmsListUserIsAssociatedWith;
    }

    public function articleIsNew()
    {
        return $this->article->id == null;
    }

    /**
     * @return mixed
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @return mixed
     */
    public function getStatuses()
    {
        return $this->statuses;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @return mixed
     */
    public function getDefaultCategories()
    {
        return $this->defaultCategories;
    }

    /**
     * @return mixed
     */
    public function getCMS()
    {
        return $this->cms;
    }

    /**
     * @return mixed
     */
    public function getCMSToSendACopyOfTheArticle()
    {
        return $this->cmsToSendACopyOfTheArticle;
    }

    /**
     * @return mixed
     */
    public function getCmsIdsListArticleHasAlreadyBeenSent()
    {
        return $this->cmsIdsListArticleHasAlreadyBeenSent;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    public function getPixelatedImagePath()
    {
        return $this->pixelatedImagePath;
    }

    /**
     * @return int
     */
    public function getTotalPeopleRespondedInRequests(): int
    {
        return $this->totalPeopleRespondedInRequests;
    }

    public function articleHasCategory($category)
    {
        return in_array($category->id, $this->articleCategoriesIds);
    }

    public function articleHasTag($tag)
    {
        return in_array($tag->id, $this->articleTagsIds);
    }

    public function getArticlesUserHasSentToPublishers()
    {
        return $this->articlesUserHasSentToPublishers;
    }

    public function getArticleIsAProductOfPurchaseFromStore()
    {
        return $this->articleIsAProductOfPurchaseFromStore;
    }

    public function getArticleStatusCSSName($statusId = null)
    {
        if (empty($statusId))
            $statusId = $this->article->status_id;
        switch ($statusId) {
            case ArticleStatuses::Draft:
                return 'draft';
            case ArticleStatuses::Published:
                return 'published';
            case ArticleStatuses::Unpublished:
                return 'unpublished';
            case ArticleStatuses::ScheduledForRelease:
                return 'scheduled';
            case ArticleStatuses::Deleted:
                return 'deleted';
        }
        return '';
    }

    private function getTotalPeopleResponded($article)
    {
        $totalPeopleResponded = 0;
        foreach ($article->collaborationRequests as $request) {
            foreach ($request->collaborationResponses as $response) {
                // if it is "in progress" or "completed" it means that the person has responded
                if (array_search($response->status_id, [3, 4]) !== false)
                    $totalPeopleResponded++;
            }
        }
        return $totalPeopleResponded;
    }
}