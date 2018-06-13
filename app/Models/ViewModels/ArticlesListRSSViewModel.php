<?php

namespace App\Models\ViewModels;


class ArticlesListRSSViewModel {

    public $articles;
    public $cms;

    public function __construct($articles, $cms)
    {
        $this->articles = $articles;

        $this->cms = $cms;
    }
}