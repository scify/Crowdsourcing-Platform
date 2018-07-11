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

    public function __construct($questionnaires, $statuses)
    {
        $temp = [];
        $this->statuses = $statuses;
        foreach ($questionnaires as $questionnaireGroup) {
            $questionnaireIsAlreadyPushed = false;
            $languages = [];
            foreach ($questionnaireGroup as $questionnaire) {
                array_push($languages, $questionnaire->language_name);
                if (!$questionnaireIsAlreadyPushed) {
                    unset($questionnaire->language_id);
                    unset($questionnaire->language_name);
                    $questionnaire->status_css_class = $this->setCssClassForStatus($questionnaire->status_title);
                    array_push($temp, $questionnaire);
                }
                $questionnaireIsAlreadyPushed = true;
            }
            $temp[count($temp) - 1]->languages = $languages;
        }
        $this->questionnaires = collect($temp);
    }

    private function setCssClassForStatus($status)
    {
        return self::STATUSES_CSS_CLASSES[$status];
    }
}