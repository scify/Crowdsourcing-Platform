<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/11/18
 * Time: 12:05 PM
 */

namespace App\Models\ViewModels;


use App\BusinessLogicLayer\lkp\QuestionnaireStatusLkp;

class ManageQuestionnaires
{
    const STATUSES_CSS_CLASSES = [
        QuestionnaireStatusLkp::DRAFT => 'badge-warning',
        QuestionnaireStatusLkp::PUBLISHED => 'badge-success',
        QuestionnaireStatusLkp::FINALIZED => 'badge-primary',
        QuestionnaireStatusLkp::UNPUBLISHED => 'badge-danger',
        QuestionnaireStatusLkp::DELETED => 'badge-danger'
    ];
    public $questionnaires;
    public $statuses;

    public function __construct($questionnaires, $statuses) {
        $this->statuses = $statuses;
        $this->questionnaires = $questionnaires;
    }

    public function setCssClassForStatus($status) {
        return self::STATUSES_CSS_CLASSES[$status];
    }
}
