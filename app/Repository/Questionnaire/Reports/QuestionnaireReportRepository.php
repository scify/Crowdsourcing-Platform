<?php

namespace App\Repository\Questionnaire\Reports;

use Illuminate\Support\Facades\DB;

class QuestionnaireReportRepository {

    public function getReportDataForUsers($questionnaireId) {
        return DB::select('
            select u.email, u.nickname,  qra.question_id, qra.answer_id, qpa.answer, qrat.answer as text_answer, 
            qrat.english_translation as answer_english_translation, qrat.initial_language_detected as answer_initial_language_detected, qq.question
            from questionnaire_responses as qr

                inner join users as u on u.id = qr.user_id
                inner join questionnaires q on q.id = qr.questionnaire_id
                left outer join questionnaire_response_answers qra on qra.questionnaire_response_id = qr.id
                inner join questionnaire_questions qq on qq.id = qra.question_id
                left outer join questionnaire_possible_answers qpa on qpa.question_id = qq.id and qpa.id = qra.answer_id
                left outer join questionnaire_response_answer_texts qrat on qrat.questionnaire_response_answer_id = qra.id
                
            where qr.questionnaire_id = ' . $questionnaireId . ' and qr.deleted_at is null
            order by u.email, qq.order_id, qpa.id;
        ');
    }

    public function getRespondentsData($questionnaireId) {
        return DB::select('
             select questionnaire_responses.id, questionnaire_id, 
             users.email, questionnaire_responses.deleted_at, users.deleted_at, questionnaire_responses.updated_at as answered_at
             from questionnaire_responses inner join users on users.id=questionnaire_responses.user_id
             where questionnaire_responses.questionnaire_id = ' . $questionnaireId . ' and questionnaire_responses.deleted_at is null and users.deleted_at is null;
        ');
    }
}
