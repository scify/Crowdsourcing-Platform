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
        'Draft' => 'badge-warning',
        'Published' => 'badge-success',
        'Finalized' => 'badge-primary',
        'Unpublished' => 'badge-danger',
        'Deleted' => 'badge-danger'
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
