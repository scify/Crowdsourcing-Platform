<?php

namespace App\Repository\Questionnaire\Responses;

use App\Models\Questionnaire\QuestionnaireAnswerVote;
use App\Repository\Repository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class QuestionnaireAnswerVoteRepository extends Repository {

    /**
     * @inheritDoc
     */
    function getModelClassName() {
        return QuestionnaireAnswerVote::class;
    }

    public function getAnswerVotesForQuestionnaireAnswers(int $questionnaire_id): Collection {
        return collect(DB::
        select("
                select qav.question_name, 
                qav.respondent_user_id,
                qav.voter_user_id,
                qav.upvote,
                ifnull(upvotesInfo.num_upvotes, false) as num_upvotes,
                ifnull(downvotesInfo.num_downvotes, false) as num_downvotes
                from questionnaire_answer_votes qav
                
                left outer join (
                    select qav3.question_name,qav3.respondent_user_id, count(*) as num_upvotes
                    from questionnaire_answer_votes qav3
                    where qav3.questionnaire_id = " . $questionnaire_id . " and qav3.upvote = 1
                    group by qav3.question_name, qav3.respondent_user_id
                ) as upvotesInfo on upvotesInfo.question_name = qav.question_name and upvotesInfo.respondent_user_id = qav.respondent_user_id
                
                left outer join (
                    select qav4.question_name,qav4.respondent_user_id, count(*) as num_downvotes
                    from questionnaire_answer_votes qav4
                    where qav4.questionnaire_id = " . $questionnaire_id . " and qav4.upvote = 0
                    group by qav4.question_name, qav4.respondent_user_id
                ) as downvotesInfo on downvotesInfo.question_name = qav.question_name and downvotesInfo.respondent_user_id = qav.respondent_user_id
                
                where qav.questionnaire_id = " . $questionnaire_id . "
                group by qav.question_name, qav.respondent_user_id, qav.voter_user_id,
                 qav.upvote, upvotesInfo.num_upvotes, downvotesInfo.num_downvotes
                order by qav.question_name, qav.respondent_user_id;
        "));
    }

    public function deleteAnswerVotesByUser(int $id) {
        return QuestionnaireAnswerVote::whereIn('voter_user_id', [$id])->delete();
    }

    public function restoreAnswerVotesByUser(int $id) {
        return QuestionnaireAnswerVote::onlyTrashed()->whereIn('voter_user_id', [$id])->restore();
    }

    public function getAnswerVotesWithVoterInfoForQuestionnaire(int $questionnaire_id): Collection {
        return collect(DB::
        select('
            select  qr.id as response_id,
                    qr.response_json,
                    qr.response_json_translated,
                    qav.question_name,
                    qav.respondent_user_id,
                group_concat(concat(u.nickname, " (", u.email, ")")) as voters,
                upvotesInfo.num_upvotes as votes
                from questionnaire_answer_votes qav
                
                left outer join (
                    select qav3.question_name,qav3.respondent_user_id, count(*) as num_upvotes
                    from questionnaire_answer_votes qav3
                    where qav3.questionnaire_id = ' . $questionnaire_id . ' and qav3.upvote = 1
                    group by qav3.question_name, qav3.respondent_user_id
                ) as upvotesInfo on upvotesInfo.question_name = qav.question_name and upvotesInfo.respondent_user_id = qav.respondent_user_id
                
                inner join users u on u.id = qav.voter_user_id
                inner join questionnaire_responses qr on qr.questionnaire_id = qav.questionnaire_id and qr.user_id = qav.respondent_user_id
                
                where qav.questionnaire_id = ' . $questionnaire_id . '
                and qr.deleted_at is null
                and u.deleted_at is null
                group by response_id, qr.response_json, qr.response_json_translated,
                qav.respondent_user_id, question_name, upvotesInfo.num_upvotes
                order by upvotesInfo.num_upvotes desc;
        '));
    }
}
