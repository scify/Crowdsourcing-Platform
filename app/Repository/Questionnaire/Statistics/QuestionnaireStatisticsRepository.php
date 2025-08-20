<?php

declare(strict_types=1);

namespace App\Repository\Questionnaire\Statistics;

use Illuminate\Support\Facades\DB;

class QuestionnaireStatisticsRepository {
    /**
     * * getQuestionnaireResponseStatistics
     * * Returns responses vs goal responses.
     * *
     * * @param  mixed  $questionnaireId
     * */
    public function getQuestionnaireResponseStatistics($questionnaireId): QuestionnaireResponseStatistics {
        $totalResponses = DB::select(
            'select count(*) as count, qbsc.total_responses_color
                    from questionnaire_responses as qr
                    left outer join questionnaire_basic_statistics_colors as qbsc
                    on qbsc.questionnaire_id = qr.questionnaire_id
                    where qr.questionnaire_id = ? and deleted_at is null
                    group by qbsc.total_responses_color;', [$questionnaireId]);
        $goalResponses = DB::select(
            'select goal, qbsc.goal_responses_color from questionnaires
                    left outer join questionnaire_basic_statistics_colors as qbsc
                    on qbsc.questionnaire_id = questionnaires.id
                    where questionnaires.id = ? and questionnaires.deleted_at is null;', [$questionnaireId]);

        return new QuestionnaireResponseStatistics(
            count($totalResponses) !== 0 ? $totalResponses[0]->count : 0,
            $goalResponses[0]->goal,
            count($totalResponses) !== 0 ? $totalResponses[0]->total_responses_color : null,
            $goalResponses[0]->goal_responses_color
        );
    }

    /**
     * * getNumberOfResponsesPerLanguage
     * * Returns number of responses per language.
     * *
     * * @param  mixed  $questionnaireId
     * */
    public function getNumberOfResponsesPerLanguage($questionnaireId): \App\Repository\Questionnaire\Statistics\QuestionnaireResponsesPerLanguage {
        $query = DB::select('SELECT count(*) as num_responses, 
                            language_code, language_name, 
                            ifnull(ql.color, default_color) as color 
                            FROM questionnaire_responses as qr
                            join languages_lkp as ll on qr.language_id = ll.id
                            left outer join questionnaire_languages as ql on ql.language_id = ll.id
                            where qr.questionnaire_id = ?
                            and ql.questionnaire_id = ?
                            and qr.deleted_at is null
                            and ql.deleted_at is null
                            and ll.deleted_at is null
                            group by language_code, language_name, color, ll.default_color;', [$questionnaireId, $questionnaireId]);

        return new QuestionnaireResponsesPerLanguage($query);
    }
}
