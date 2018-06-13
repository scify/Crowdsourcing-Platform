<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 5/8/18
 * Time: 11:23 AM
 */

namespace App\Models\ViewModels;


use Carbon\Carbon;

class ArticlePurchase
{
    public $id;
    public $originalArticle;
    public $generatedArticle;
    public $costString;
    public $creatorName;
    public $creatorEmail;
    public $buyerName;
    public $buyerEmail;
    public $purchasedAtString;
    public $paymentSentToCreator;
    public $paymentReceivedFromBuyer;

    public function __construct($articlePurchase)
    {
        $this->id = $articlePurchase->id;
        $this->originalArticle = $articlePurchase->article;
        $this->generatedArticle = $articlePurchase->generatedArticle;
        $this->costString = number_format($articlePurchase->cost, 2) . '€';
        $this->creatorName = $articlePurchase->creator->name . ' ' . $articlePurchase->creator->surname;
        $this->creatorEmail = $articlePurchase->creator->email;
        $this->buyerName = $articlePurchase->userPurchased->name . ' ' . $articlePurchase->userPurchased->surname;
        $this->buyerEmail = $articlePurchase->userPurchased->email;
        $this->purchasedAtString = Carbon::createFromFormat('Y-m-d H:i:s', $articlePurchase->purchased_at)->format('d/m/Y H:i:s');
        $this->paymentSentToCreator = $articlePurchase->payment_processed_for_creator;
        $this->paymentReceivedFromBuyer = $articlePurchase->payment_processed_for_buyer;
    }
}