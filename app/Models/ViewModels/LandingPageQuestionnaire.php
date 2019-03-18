<?php
/**
 * Created by IntelliJ IDEA.
 * User: pisaris
 * Date: 18/3/2019
 * Time: 12:34 μμ
 */

namespace App\Models\ViewModels;


class LandingPageQuestionnaire {


    public $userResponse;
    public $allResponses;
    public $allLanguagesForQuestionnaire;
    public $questionnaire;

    public function __construct($questionnaire, $userResponse,
                                $allResponses,
                                $allLanguagesForQuestionnaire) {
        $this->userResponse = $userResponse;
        $this->allResponses = $allResponses;
        $this->allLanguagesForQuestionnaire = $allLanguagesForQuestionnaire;
        $this->questionnaire = $questionnaire;
    }
}