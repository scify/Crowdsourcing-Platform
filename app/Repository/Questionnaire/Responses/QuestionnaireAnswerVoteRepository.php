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

    public function getAnswerVotesForQuestionnaireAnswers(int $questionnaire_id, int $user_voter_id): Collection {
        return collect(DB::
        select("
                select qav.question_name, 
                qav.respondent_user_id,
                ifnull(upvoteInfo.upvoted, false) as upvoted_by_user, 
                ifnull(downvoteInfo.downvoted, false) as downvoted_by_user,
                ifnull(upvotesInfo.num_upvotes, false) as num_upvotes,
                ifnull(downvotesInfo.num_downvotes, false) as num_downvotes
                from questionnaire_answer_votes qav
                left outer join (
                    select qav1.question_name,qav1.respondent_user_id, count(*) as upvoted
                    from questionnaire_answer_votes qav1
                    where qav1.questionnaire_id = " . $questionnaire_id . "
                    and voter_user_id = " . $user_voter_id . "
                    and qav1.upvote = 1
                    group by qav1.question_name, qav1.respondent_user_id
                ) as upvoteInfo on upvoteInfo.question_name = qav.question_name and upvoteInfo.respondent_user_id = qav.respondent_user_id
                
                left outer join (
                    select qav2.question_name,qav2.respondent_user_id, count(*) as downvoted
                    from questionnaire_answer_votes qav2
                    where qav2.questionnaire_id = " . $questionnaire_id . "
                    and voter_user_id = " . $user_voter_id . "
                    and qav2.upvote = 0
                    group by qav2.question_name, qav2.respondent_user_id
                ) as downvoteInfo on downvoteInfo.question_name = qav.question_name and downvoteInfo.respondent_user_id = qav.respondent_user_id
                
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
                group by qav.question_name, qav.respondent_user_id
                order by qav.question_name, qav.respondent_user_id;
        "));
    }

    public function deleteAnswerVotesByUser(int $id) {
        return QuestionnaireAnswerVote::whereIn('user_id', $id)->delete();
    }

    public function restoreAnswerVotesByUser(int $id) {
        return QuestionnaireAnswerVote::onlyTrashed()->whereIn('user_id', $id)->restore();
    }
}
