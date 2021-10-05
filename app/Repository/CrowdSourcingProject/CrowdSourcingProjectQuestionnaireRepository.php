<?php


namespace App\Repository\CrowdSourcingProject;


use App\Models\CrowdSourcingProject\CrowdSourcingProjectQuestionnaire;
use App\Repository\Repository;

class CrowdSourcingProjectQuestionnaireRepository extends Repository {

    /**
     * @inheritDoc
     */
    function getModelClassName() {
        return CrowdSourcingProjectQuestionnaire::class;
    }

    public function setQuestionnaireToProjects(int $questionnaire_id, array $project_ids) {
        $existing_project_ids = $this->allWhere(['questionnaire_id' => $questionnaire_id])->pluck('project_id')->toArray();
        foreach ($project_ids as $project_id) {
            if (in_array($project_id, $existing_project_ids))
                array_splice($existing_project_ids, array_search($project_id, $existing_project_ids), 1);
            $data = [
                'project_id' => $project_id,
                'questionnaire_id' => $questionnaire_id
            ];
            $this->updateOrCreate(
                $data,
                $data
            );
        }
        foreach ($existing_project_ids as $project_id) {
            $this->removeQuestionnaireFromProject($questionnaire_id, $project_id);
        }
    }

    public function addQuestionnaireToCrowdSourcingProject(int $questionnaire_id, int $project_id) {
        $data = [
            'questionnaire_id' => $questionnaire_id,
            'project_id' => $project_id
        ];
        return $this->updateOrCreate($data, $data);
    }

    public function removeQuestionnaireFromProject(int $questionnaire_id, int $project_id) {
        $data = [
            'questionnaire_id' => $questionnaire_id,
            'project_id' => $project_id
        ];
        return CrowdSourcingProjectQuestionnaire::where($data)->delete();
    }
}
