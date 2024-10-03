<?php

namespace Tests\Unit\Repository\Questionnaire;

use App\Models\Questionnaire\Questionnaire;
use App\Models\Questionnaire\QuestionnaireAnswerVote;
use App\Models\User;
use App\Repository\Questionnaire\Responses\QuestionnaireAnswerVoteRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionnaireAnswerVoteRepositoryTest extends TestCase {
    use RefreshDatabase;

    protected $seed = true;

    /** @test
     * @throws BindingResolutionException
     */
    public function getAnswerVotesForQuestionnaireAnswers_returns_correct_votes() {
        $questionnaire = Questionnaire::factory()->create();
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        QuestionnaireAnswerVote::factory()->create([
            'questionnaire_id' => $questionnaire->id,
            'question_name' => 'question1',
            'respondent_user_id' => $user1->id,
            'voter_user_id' => $user2->id,
            'upvote' => true,
        ]);

        $repository = $this->app->make(QuestionnaireAnswerVoteRepository::class);
        $votes = $repository->getAnswerVotesForQuestionnaireAnswers($questionnaire->id);

        $this->assertCount(1, $votes);
        $this->assertEquals('question1', $votes->first()->question_name);
        $this->assertEquals($user1->id, $votes->first()->respondent_user_id);
        $this->assertEquals($user2->id, $votes->first()->voter_user_id);
        $this->assertEquals($votes->first()->upvote, 1);
    }

    /** @test
     * @throws BindingResolutionException
     */
    public function getAnswerVotesForQuestionnaireAnswers_returns_empty_collection_for_nonexistent_questionnaire() {
        $repository = $this->app->make(QuestionnaireAnswerVoteRepository::class);
        $votes = $repository->getAnswerVotesForQuestionnaireAnswers(999);

        $this->assertCount(0, $votes);
    }

    /** @test
     * @throws BindingResolutionException
     */
    public function getAnswerVotesForQuestionnaireAnswers_handles_multiple_votes_correctly() {
        $questionnaire = Questionnaire::factory()->create();
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        QuestionnaireAnswerVote::factory()->create([
            'questionnaire_id' => $questionnaire->id,
            'question_name' => 'question1',
            'respondent_user_id' => $user1->id,
            'voter_user_id' => $user2->id,
            'upvote' => true,
        ]);

        QuestionnaireAnswerVote::factory()->create([
            'questionnaire_id' => $questionnaire->id,
            'question_name' => 'question1',
            'respondent_user_id' => $user1->id,
            'voter_user_id' => $user3->id,
            'upvote' => false,
        ]);

        $repository = $this->app->make(QuestionnaireAnswerVoteRepository::class);
        $votes = $repository->getAnswerVotesForQuestionnaireAnswers($questionnaire->id);

        $this->assertCount(2, $votes);
        $this->assertEquals('question1', $votes->first()->question_name);
        $this->assertEquals($user1->id, $votes->first()->respondent_user_id);
        $this->assertEquals($votes->first()->upvote, 1);
        $this->assertEquals($votes->last()->upvote, 0);
    }
}
