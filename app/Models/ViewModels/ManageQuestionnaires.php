<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/11/18
 * Time: 12:05 PM
 */

namespace App\Models\ViewModels;


class ManageQuestionnaires
{
    const STATUSES_CSS_CLASSES = [
        'Draft' => 'label-warning',
        'Published' => 'label-success',
        'Finalized' => 'label-primary',
        'Unpublished' => 'label-danger',
        'Deleted' => 'label-danger'
    ];
    public $questionnaires;
    public $statuses;
    public $projectId;

    public function __construct($questionnaires, $statuses, $projectId) {
        $this->statuses = $statuses;
        $this->questionnaires = $questionnaires;
        $this->projectId = $projectId;
    }

    public function setCssClassForStatus($status) {
        return self::STATUSES_CSS_CLASSES[$status];
    }
}