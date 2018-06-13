<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 5/2/18
 * Time: 5:13 PM
 */

namespace App\Models\ViewModels;


class OnlineStoreViewModel
{
    public $articlesStoreInfo;
    public $pagingHtml;
    public $defaultCategories;
    public $filterParams;

    public function __construct($articlesStoreInfo, $pagingHtml, $defaultCategories, $filterParams) {
        $this->articlesStoreInfo = $articlesStoreInfo;
        $this->pagingHtml = $pagingHtml;
        $this->defaultCategories = $defaultCategories;
        $this->filterParams = $filterParams;
    }
}