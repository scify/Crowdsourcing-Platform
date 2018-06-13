<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 4/17/18
 * Time: 1:01 PM
 */

namespace App\Models\ViewModels;


class PurchaseArticleResponse
{
    public $purchaseCompleted;
    public $redirectUrl;
    public $validationMessage;

    /**
     * PurchaseArticleResponse constructor.
     * @param $purchaseCompleted
     * @param $redirectUrl
     * @param $validationMessage
     */
    public function __construct($purchaseCompleted, $redirectUrl, $validationMessage)
    {
        $this->purchaseCompleted = $purchaseCompleted;
        $this->redirectUrl = $redirectUrl;
        $this->validationMessage = $validationMessage;
    }


}