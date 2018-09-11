<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class QuestionnaireReportRepository {

    public function getReportDataForUsers($questionnaireId) {
        return DB::select('
            select u.email, u.nickname,  qra.question_id, qra.answer_id, qpa.answer, qrat.answer as text_answer, 
            qrat.english_translation as answer_english_translation, qrat.initial_language_detected as answer_initial_language_detected, qq.question
            from questionnaire_responses as qr

                inner join users as u on u.id = qr.user_id
                inner join questionnaires q on q.id = qr.questionnaire_id
                inner join questionnaire_response_answers qra on qra.questionnaire_response_id = qr.id
                inner join questionnaire_questions qq on qq.id = qra.question_id
                left outer join questionnaire_possible_answers qpa on qpa.question_id = qq.id and qpa.id = qra.answer_id
                left outer join questionnaire_response_answer_texts qrat on qrat.questionnaire_response_answer_id = qra.id
                
            where qr.questionnaire_id = ' . $questionnaireId . ' and qr.deleted_at is null
            order by u.email, qq.id, qpa.id;
        ');
    }

    public function getReportDataForAnswers($questionnaireId) {
        return DB::select('
                select
                q.id as questionnaire_id,
                qq.id as question_id, 
                qq.question,
                qpa.id as answer_id,
                qpa.answer,
                IFNULL(ResponseCounts.num_of_responses,0) as num_of_responses
                
                from 
                    questionnaires q 
                    inner join questionnaire_questions qq on qq.questionnaire_id = q.id
                    left outer join questionnaire_possible_answers qpa on qpa.question_id = qq.id
                
                    left outer join
                        (
                        select 
                            question_id,answer_id, count(*) as num_of_responses
                            from questionnaire_response_answers  qra
                                inner join questionnaire_questions qq on qq.id = qra.question_id
                                where qq.questionnaire_id = ' . $questionnaireId . '
                                group by question_id,answer_id
                        ) as ResponseCounts on  ResponseCounts.question_id = qq.id and ResponseCounts.answer_id <=>  qpa.id
                   
                where 
                q.id = 1 
                and qq.type <> "html"
                
                and qq.deleted_at is null
                and qpa.deleted_at is null 
                order by qq.id, qpa.id
        ');
    }
}