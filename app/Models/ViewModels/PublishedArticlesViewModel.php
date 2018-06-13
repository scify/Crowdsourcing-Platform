<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 4/17/18
 * Time: 1:01 PM
 */

namespace App\Models\ViewModels;


use Illuminate\Support\Collection;

class PublishedArticlesViewModel
{
    public $articles;
    public $pagingHtml;

    public function __construct($articles, $pagingHtml)
    {
        $this->articles = $articles;
        $this->pagingHtml = $pagingHtml;
    }
}