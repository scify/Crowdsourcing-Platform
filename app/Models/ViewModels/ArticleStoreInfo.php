<?php

namespace App\Models\ViewModels;


class ArticleStoreInfo
{
    public $storeInfoId;
    public $onlineStoreUrl;
    public $totalPurchases;
    public $totalEarnings;

    public function __construct($articleId, $storeInfoId, $uploadedAt, $totalPurchases, $totalEarnings, $purchaseHistory)
    {
        $this->storeInfoId = $storeInfoId;
        $this->uploadedAt = $uploadedAt;
        $this->onlineStoreUrl = "/online-store/filter?article_id=$articleId";
        $this->totalPurchases = $totalPurchases;
        $this->totalEarnings = $totalEarnings;
    }


}