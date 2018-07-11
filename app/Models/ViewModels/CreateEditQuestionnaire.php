<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/11/18
 * Time: 5:06 PM
 */

namespace App\Models\ViewModels;


class CreateEditQuestionnaire
{
    public $questionnaire;
    public $languages;
    public $title;

    public function __construct($questionnaire, $languages, $title)
    {
        $this->questionnaire = $questionnaire;
        $this->languages = $languages;
        $this->title = $title;
    }
}