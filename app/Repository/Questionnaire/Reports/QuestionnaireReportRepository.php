<?php

namespace App\Repository\Questionnaire\Reports;

use Illuminate\Support\Facades\DB;

class QuestionnaireReportRepository {

    public function getRespondentsData(int $questionnaireId): array {
        return DB::select('
             select questionnaire_responses.id, questionnaire_id, 
             users.email as respondent_email, questionnaire_responses.deleted_at, users.deleted_at, 
             questionnaire_responses.created_at as answered_at,
             users.id as respondent_user_id, users.nickname as respondent_nickname
             from questionnaire_responses inner join users on users.id=questionnaire_responses.user_id
             where questionnaire_responses.questionnaire_id = ' . $questionnaireId . ' and questionnaire_responses.deleted_at is null and users.deleted_at is null;
        ');
    }
}
