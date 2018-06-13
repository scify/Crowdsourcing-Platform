<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 5/8/18
 * Time: 11:21 AM
 */

namespace App\Models\ViewModels;


use Illuminate\Support\Collection;

class ArticlePurchasesList
{
    public $articlePurchases;
    public $filterParams;

    public function __construct($articlePurchases, $filterParams)
    {
        $this->articlePurchases = new Collection();
        foreach ($articlePurchases as $articlePurchase) {
            $this->articlePurchases->push(new ArticlePurchase($articlePurchase));
        }
        $this->filterParams = $filterParams;
    }
}