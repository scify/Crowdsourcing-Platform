<?php

declare(strict_types=1);

namespace App\Repository\Questionnaire\Reports;

use Illuminate\Support\Facades\DB;

class QuestionnaireReportRepository {
    public function getRespondentsData(int $questionnaireId): array {
        return DB::select("select qr.id, questionnaire_id, 
                                     users.email as respondent_email, qr.deleted_at, users.deleted_at, 
                                     qr.created_at as answered_at,
                                     users.id as respondent_user_id, users.nickname as respondent_nickname,
                                     p.slug, t.name as project_name
                        from questionnaire_responses  qr
                        inner join users on users.id=qr.user_id
                        inner join crowd_sourcing_projects p on p.id = qr.project_id
                        inner join crowd_sourcing_project_translations t on t.project_id = p.id and t.language_id = p.language_id
                        where qr.questionnaire_id = {$questionnaireId} and qr.deleted_at is null and users.deleted_at is null;");
    }
}
