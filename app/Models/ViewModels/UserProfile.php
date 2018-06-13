<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 4/23/18
 * Time: 1:19 PM
 */

namespace App\Models\ViewModels;


use App\Models\User;

class UserProfile
{
    public $fullName;
    public $email;
    public $articles;
    public $location;
    public $totalArticlesPublishedAtOnlineStore;
    public $totalAmountEarned;
    public $totalArticlesBought;

    public function __construct(User $user, $articles,
                                $totalArticlesPublishedAtOnlineStore,
                                $totalAmountEarned,
                                $totalArticlesBought)
    {
        $this->fullName = $user->name . " " . $user->surname;
        $this->email = $user->email;
        $this->articles = $articles;
        $this->location = $user->location;

        $this->totalArticlesPublishedAtOnlineStore = $totalArticlesPublishedAtOnlineStore;
        $this->totalAmountEarned=$totalAmountEarned;
        $this->totalArticlesBought= $totalArticlesBought;
    }
}