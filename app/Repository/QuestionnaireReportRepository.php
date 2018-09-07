<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class QuestionnaireReportRepository {

    public function getReportDataForUsers($questionnaireId) {
        return DB::select('
            select u.email, u.nickname,  qra.question_id, qra.answer_id, qpa.answer, qrat.answer as text_answer, qq.question
            from questionnaire_responses as qr

                inner join users as u on u.id = qr.user_id
                inner join questionnaires q on q.id = qr.questionnaire_id
                inner join questionnaire_response_answers qra on qra.questionnaire_response_id = qr.id
                inner join questionnaire_questions qq on qq.id = qra.question_id
                left outer join questionnaire_possible_answers qpa on qpa.question_id = qq.id and qpa.id = qra.answer_id
                left outer join questionnaire_response_answer_texts qrat on qrat.questionnaire_response_answer_id = qra.id
                
            where qr.questionnaire_id = ' . $questionnaireId . ' and qr.deleted_at is null and u.deleted_at is null
            order by u.email, qq.id, qpa.id;
        ');
    }

    public function getReportDataForAnswers($questionnaireId) {
        return DB::select('
            select  qra.question_id, qra.answer_id, count(*) as num_of_times, qpa.answer, qrat.answer as text_answer, qq.question

            from questionnaire_responses as qr
            
                inner join questionnaires q on q.id = qr.questionnaire_id
                inner join questionnaire_response_answers qra on qra.questionnaire_response_id = qr.id
                inner join questionnaire_questions qq on qq.id = qra.question_id
                left outer join questionnaire_possible_answers qpa on qpa.question_id = qq.id and qpa.id = qra.answer_id
                left outer join questionnaire_response_answer_texts qrat on qrat.questionnaire_response_answer_id = qra.id
            
            where qr.questionnaire_id = ' . $questionnaireId . ' and qr.deleted_at is null
            
            group by qra.question_id, qra.answer_id, qpa.answer, qrat.answer, qq.question
            order by qq.id, qpa.id;
        ');
    }
}