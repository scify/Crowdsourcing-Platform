<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 4/17/18
 * Time: 1:01 PM
 */

namespace App\Models\ViewModels;


use Illuminate\Support\Collection;

class ArticlesForList
{
    public $articles;
    public $pageTitle;
    public $canManageArticles;
    public $canPublishArticles;
    public $canSeeStatus;
    public $canSeeIfPurchased;
    public $displayCMSColumn;
    public $canSeePurchasedArticlesFilter;
    public $canSeeStoreStatus;
    public $filterParams;

    public function __construct($articles, $pageTitle, $canManageArticles, $canPublishArticles, $canSeeStatus,
                                $canSeeIfPurchased, $displayCMSColumn, $canSeePurchasedArticlesFilter,
                                $canSeeStoreStatus, $filters)
    {
        $this->articles = new Collection();
        foreach ($articles as $article) {
            $this->articles->push(new ArticleEnriched($article));
        }
        $this->pageTitle = $pageTitle;
        $this->canManageArticles = $canManageArticles;
        $this->canPublishArticles = $canPublishArticles;
        $this->canSeeStatus = $canSeeStatus;
        $this->canSeeIfPurchased = $canSeeIfPurchased;
        $this->displayCMSColumn = $displayCMSColumn;
        $this->canSeePurchasedArticlesFilter = $canSeePurchasedArticlesFilter;
        $this->canSeeStoreStatus = $canSeeStoreStatus;
        $this->filterParams = $filters;
    }

}