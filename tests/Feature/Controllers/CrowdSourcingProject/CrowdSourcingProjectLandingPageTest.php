<?php

namespace Feature\Controllers\CrowdSourcingProject;

use App\BusinessLogicLayer\lkp\ProblemStatusLkp;
use App\BusinessLogicLayer\lkp\QuestionnaireStatusLkp;
use App\BusinessLogicLayer\lkp\QuestionnaireTypeLkp;
use App\BusinessLogicLayer\lkp\UserRolesLkp;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Problem\Problem;
use App\Models\Problem\ProblemTranslation;
use App\Models\Questionnaire\Questionnaire;
use App\Models\Questionnaire\QuestionnaireResponse;
use App\Models\User\User;
use App\Models\User\UserRole;
use Tests\TestCase;

class CrowdSourcingProjectLandingPageTest extends TestCase {
    /**
     * @test
     *
     * @group crowd-sourcing-project
     *
     * Test Scenario 1:
     * GIVEN that a Project Campaign does not have any Questionnaire
     *
     * AND there exist published Problems associated with the Project  ,
     *
     * WHEN the user navigates in the Project Campaign page,
     *
     * THEN the user should see the CTA to contribute to the Problems campaign
     *
     * @return void
     */
    public function test_user_should_see_cta_for_problems_campaign_page() {
        // Given that a registered user has responded to the questionnaire
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::REGISTERED_USER]))
            ->create();
        $this->be($user);

        // Create a Crowd Sourcing Project (Campaign)
        $project = CrowdSourcingProject::factory()->create();

        // Create some Problems and attach them to the Campaign
        $problems = Problem::factory(3)->create([
            'project_id' => $project->id,
        ]);

        // Create a Problem Translation for each Problem
        foreach ($problems as $problem) {
            ProblemTranslation::factory()->create([
                'problem_id' => $problem->id,
            ]);
        }

        // When the user navigates in the Project Campaign page
        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'slug' => $project->slug]));

        // We need to assert that the page has the Problems Call-to-Action (CTA) button
        $response->assertSee('See all problems');
    }

    /**
     * @test
     *
     * @group crowd-sourcing-project
     *
     * Test Scenario 2:
     * GIVEN that a Project Campaign does have an active Questionnaire
     *
     * AND there exist published Problems associated with the Project  ,
     *
     * WHEN the user navigates in the Project Campaign page,
     *
     * THEN the user should see the CTA to answer the Questionnaire
     * @return void
     */
    public function test_user_should_see_cta_for_questionnaire() {
        // Given that a registered user has responded to the questionnaire
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::REGISTERED_USER]))
            ->create();
        $this->be($user);

        // Create a Crowd Sourcing Project (Campaign)
        $project = CrowdSourcingProject::factory()->create();

        // Create some Problems and attach them to the Campaign
        $problems = Problem::factory(3)->create([
            'project_id' => $project->id,
        ]);

        // Create a Problem Translation for each Problem
        foreach ($problems as $problem) {
            ProblemTranslation::factory()->create([
                'problem_id' => $problem->id,
            ]);
        }

        // Create a Questionnaire for the Project
        $questionnaire = Questionnaire::factory()->create([
            'project_id' => $project->id,
            'status_id' => QuestionnaireStatusLkp::PUBLISHED,
        ]);

        // When the user navigates in the Project Campaign page
        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'slug' => $project->slug]));

        // We need to assert that the page has the Questionnaire Call-to-Action (CTA) button
        $response->assertSee('Answer the questionnaire');
    }

    /**
     * @test
     *
     * @group crowd-sourcing-project
     *
     * Test Scenario 3:
     * GIVEN that a Project Campaign does have an active Questionnaire
     *
     * AND there exist published Problems associated with the Project  ,
     *
     * AND the user has already answered the Questionnaire
     *
     * WHEN the user navigates in the Project Campaign page,
     *
     * THEN the user should see the CTA to contribute to the Problems campaign
     * @return void
     */
    public function test_user_should_see_cta_for_problems_campaign_page_after_answering_questionnaire() {
        // Given that a registered user has responded to the questionnaire
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::REGISTERED_USER]))
            ->create();
        $this->be($user);

        // Create a Crowd Sourcing Project (Campaign)
        $project = CrowdSourcingProject::factory()->create();

        // Create some Problems and attach them to the Campaign
        $problems = Problem::factory(3)->create([
            'project_id' => $project->id,
        ]);

        // Create a Problem Translation for each Problem
        foreach ($problems as $problem) {
            ProblemTranslation::factory()->create([
                'problem_id' => $problem->id,
            ]);
        }

        // Create a Questionnaire for the Project
        $questionnaire = Questionnaire::factory()->create([
            'project_id' => $project->id,
            'status_id' => QuestionnaireStatusLkp::PUBLISHED,
        ]);

        // Create a response for the Questionnaire
        $questionnaire_response = QuestionnaireResponse::factory()->create([
            'questionnaire_id' => $questionnaire->id,
            'user_id' => $user->id,
        ]);

        // When the user navigates in the Project Campaign page
        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'slug' => $project->slug]));

        // We need to assert that the page has the Problems Call-to-Action (CTA) button
        $response->assertSee('See all problems');
    }

    /**
     * @test
     *
     * @group crowd-sourcing-project
     *
     * Test Scenario 4:
     * GIVEN that a Project Campaign has a finalized and a draft Questionnaire
     *
     * AND there exist published Problems associated with the Project  ,
     *
     * AND the user has already answered the finalized Questionnaire
     *
     * WHEN the user navigates in the Project Campaign page,
     *
     * THEN the user should see the CTA to contribute to the Problems campaign
     * @return void
     */
    public function test_user_should_see_cta_for_problems_campaign_page_after_answering_completed_questionnaire() {
        // Given that a registered user has responded to the questionnaire
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::REGISTERED_USER]))
            ->create();
        $this->be($user);

        // Create a Crowd Sourcing Project (Campaign)
        $project = CrowdSourcingProject::factory()->create();

        // Create some Problems and attach them to the Campaign
        $problems = Problem::factory(3)->create([
            'project_id' => $project->id,
        ]);

        // Create a Problem Translation for each Problem
        foreach ($problems as $problem) {
            ProblemTranslation::factory()->create([
                'problem_id' => $problem->id,
            ]);
        }

        // Create a Questionnaire for the Project
        $questionnaire_finalized = Questionnaire::factory()->create([
            'project_id' => $project->id,
            'status_id' => QuestionnaireStatusLkp::FINALIZED,
        ]);

        $questionnaire_draft = Questionnaire::factory()->create([
            'project_id' => $project->id,
            'status_id' => QuestionnaireStatusLkp::DRAFT,
        ]);

        // Create a response for the Questionnaire
        $questionnaire_response = QuestionnaireResponse::factory()->create([
            'questionnaire_id' => $questionnaire_finalized->id,
            'user_id' => $user->id,
        ]);

        // When the user navigates in the Project Campaign page
        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'slug' => $project->slug]));

        // We need to assert that the page has the Problems Call-to-Action (CTA) button
        $response->assertSee('See all problems');
    }

    /**
     * @test
     *
     * @group crowd-sourcing-project
     *
     * Test Scenario 5:
     * GIVEN that a Project Campaign has a finalized and a draft Questionnaire
     *
     * AND there exist published Problems associated with the Project  ,
     *
     * AND the user has not answered the finalized Questionnaire
     *
     * WHEN the user navigates in the Project Campaign page,
     *
     * THEN the user should see the CTA to contribute to the Problems campaign
     * @return void
     */
    public function test_user_should_see_cta_for_problems_campaign_page_without_answering_completed_questionnaire() {
        // Given that a registered user has responded to the questionnaire
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::REGISTERED_USER]))
            ->create();
        $this->be($user);

        // Create a Crowd Sourcing Project (Campaign)
        $project = CrowdSourcingProject::factory()->create();

        // Create some Problems and attach them to the Campaign
        $problems = Problem::factory(3)->create([
            'project_id' => $project->id,
        ]);

        // Create a Problem Translation for each Problem
        foreach ($problems as $problem) {
            ProblemTranslation::factory()->create([
                'problem_id' => $problem->id,
            ]);
        }

        // Create a Questionnaire for the Project
        $questionnaire_finalized = Questionnaire::factory()->create([
            'project_id' => $project->id,
            'status_id' => QuestionnaireStatusLkp::FINALIZED,
        ]);

        $questionnaire_draft = Questionnaire::factory()->create([
            'project_id' => $project->id,
            'status_id' => QuestionnaireStatusLkp::DRAFT,
        ]);

        // When the user navigates in the Project Campaign page
        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'slug' => $project->slug]));

        // We need to assert that the page has the Questionnaire Call-to-Action (CTA) button
        $response->assertSee('Answer the questionnaire');
    }

    /**
     * @test
     *
     * @group crowd-sourcing-project
     *
     * Test Scenario 6:
     * GIVEN that a Project Campaign has a finalized and a draft Questionnaire
     *
     * AND there exist only unpublished Problems associated with the Project,
     *
     * AND the Project has an external link,
     *
     * AND the user has not answered the finalized Questionnaire
     *
     * WHEN the user navigates in the Project Campaign page,
     *
     * THEN the user should see the CTA for the external link of the Project
     * @return void
     */
    public function test_user_should_see_cta_for_external_link_without_answering_completed_questionnaire() {
        // Given that a registered user has responded to the questionnaire
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::REGISTERED_USER]))
            ->create();
        $this->be($user);

        // Create a Crowd Sourcing Project (Campaign)
        $project = CrowdSourcingProject::factory()->create([
            'external_url' => 'https://www.example.com',
        ]);

        // Create some Problems and attach them to the Campaign
        $problems = Problem::factory(3)->create([
            'project_id' => $project->id,
            'status_id' => ProblemStatusLkp::UNPUBLISHED,
        ]);

        // Create a Problem Translation for each Problem
        foreach ($problems as $problem) {
            ProblemTranslation::factory()->create([
                'problem_id' => $problem->id,
            ]);
        }

        // Create a Questionnaire for the Project
        $questionnaire_finalized = Questionnaire::factory()->create([
            'project_id' => $project->id,
            'status_id' => QuestionnaireStatusLkp::FINALIZED,
        ]);

        $questionnaire_draft = Questionnaire::factory()->create([
            'project_id' => $project->id,
            'status_id' => QuestionnaireStatusLkp::DRAFT,
        ]);

        // When the user navigates in the Project Campaign page
        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'slug' => $project->slug]));

        // We need to assert that the page has the external link Call-to-Action (CTA) button
        $response->assertSee('Visit project’s site');
    }

    /**
     * @test
     *
     * @group crowd-sourcing-project
     *
     * Test Scenario 7:
     * GIVEN that a Project Campaign has a finalized and a draft Questionnaire
     *
     * AND there exist only unpublished Problems associated with the Project,
     *
     * AND the Project has an external link,
     *
     * And the Project has a published feedback questionnaire
     *
     * AND the user has not answered the finalized Questionnaire
     *
     * AND the user has not answered the feedback questionnaire
     *
     * WHEN the user navigates in the Project Campaign page,
     *
     * THEN the user should see the CTA for answering the feedback questionnaire
     * @return void
     */
    public function test_user_should_see_cta_for_feedback_questionnaire_without_answering_completed_questionnaire() {
        // Given that a registered user has responded to the questionnaire
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::REGISTERED_USER]))
            ->create();
        $this->be($user);

        // Create a Crowd Sourcing Project (Campaign)
        $project = CrowdSourcingProject::factory()->create([
            'external_url' => 'https://www.example.com',
        ]);

        // Create some Problems and attach them to the Campaign
        $problems = Problem::factory(3)->create([
            'project_id' => $project->id,
            'status_id' => ProblemStatusLkp::UNPUBLISHED,
        ]);

        // Create a Problem Translation for each Problem
        foreach ($problems as $problem) {
            ProblemTranslation::factory()->create([
                'problem_id' => $problem->id,
            ]);
        }

        // Create a Questionnaire for the Project
        $questionnaire_finalized = Questionnaire::factory()->create([
            'project_id' => $project->id,
            'status_id' => QuestionnaireStatusLkp::FINALIZED,
        ]);

        $questionnaire_draft = Questionnaire::factory()->create([
            'project_id' => $project->id,
            'status_id' => QuestionnaireStatusLkp::DRAFT,
        ]);

        // Create a feedback questionnaire for the Project
        $feedback_questionnaire = Questionnaire::factory()->create([
            'project_id' => $project->id,
            'status_id' => QuestionnaireStatusLkp::PUBLISHED,
            'type_id' => QuestionnaireTypeLkp::FEEDBACK_QUESTIONNAIRE,
        ]);

        // When the user navigates in the Project Campaign page
        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'slug' => $project->slug]));

        // We need to assert that the page has the external link Call-to-Action (CTA) button
        $response->assertSee(__('questionnaire.give_us_feedback'));
    }

    /**
     * @test
     *
     * @group crowd-sourcing-project
     *
     * Test Scenario 8:
     * GIVEN that a Project Campaign has an active and a draft Questionnaire
     *
     * AND there exist only unpublished Problems associated with the Project,
     *
     * AND the Project has an external link,
     *
     * And the Project has a published feedback questionnaire
     *
     * AND the user has already answered the finalized Questionnaire
     *
     * AND the user has already answered the feedback questionnaire
     *
     * WHEN the user navigates in the Project Campaign page,
     *
     * THEN the user should see the CTA for visiting the external link of the Project
     * @return void
     */
    public function test_user_should_see_cta_for_external_link_after_answering_questionnaire_and_feedback_questionnaire() {
        // Given that a registered user has responded to the questionnaire
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::REGISTERED_USER]))
            ->create();
        $this->be($user);

        // Create a Crowd Sourcing Project (Campaign) with an external link
        $project = CrowdSourcingProject::factory()->create([
            'external_url' => 'https://www.example.com',
        ]);

        // Create some Problems and attach them to the Campaign
        $problems = Problem::factory(3)->create([
            'project_id' => $project->id,
            'status_id' => ProblemStatusLkp::UNPUBLISHED,
        ]);

        // Create a Problem Translation for each Problem
        foreach ($problems as $problem) {
            ProblemTranslation::factory()->create([
                'problem_id' => $problem->id,
            ]);
        }

        // Create a Questionnaire for the Project
        $questionnaire = Questionnaire::factory()->create([
            'project_id' => $project->id,
            'status_id' => QuestionnaireStatusLkp::PUBLISHED,
        ]);

        $questionnaire_draft = Questionnaire::factory()->create([
            'project_id' => $project->id,
            'status_id' => QuestionnaireStatusLkp::DRAFT,
        ]);

        // Create a response for the Questionnaire
        $questionnaire_response = QuestionnaireResponse::factory()->create([
            'questionnaire_id' => $questionnaire->id,
            'user_id' => $user->id,
        ]);

        // Create a feedback questionnaire for the Project
        $feedback_questionnaire = Questionnaire::factory()->create([
            'project_id' => $project->id,
            'status_id' => QuestionnaireStatusLkp::PUBLISHED,
            'type_id' => QuestionnaireTypeLkp::FEEDBACK_QUESTIONNAIRE,
        ]);

        // Create a response for the feedback Questionnaire
        $feedback_questionnaire_response = QuestionnaireResponse::factory()->create([
            'questionnaire_id' => $feedback_questionnaire->id,
            'user_id' => $user->id,
        ]);

        // When the user navigates in the Project Campaign page
        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'slug' => $project->slug]));

        // We need to assert that the page has the external link Call-to-Action (CTA) button
        $response->assertSee(__('questionnaire.visit_projects_site'));
    }

    /**
     * @test
     *
     * @group crowd-sourcing-project
     *
     * Test Scenario 9:
     * GIVEN that a Project Campaign has an active Questionnaire
     *
     * AND there exist only unpublished Problems associated with the Project,
     *
     * AND the Project does not have an external link,
     *
     * And the Project does not have a feedback questionnaire
     *
     * AND the user has already answered the Questionnaire
     *
     * WHEN the user navigates in the Project Campaign page,
     *
     * THEN the user should see the message for sharing the questionnaire with friends
     * @return void
     */
    public function test_user_should_see_cta_for_sharing_questionnaire_after_answering_questionnaire() {
        // Given that a registered user has responded to the questionnaire
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::REGISTERED_USER]))
            ->create();
        $this->be($user);

        // Create a Crowd Sourcing Project (Campaign)
        $project = CrowdSourcingProject::factory()->create();

        // Create some Problems and attach them to the Campaign
        $problems = Problem::factory(3)->create([
            'project_id' => $project->id,
            'status_id' => ProblemStatusLkp::UNPUBLISHED,
        ]);

        // Create a Problem Translation for each Problem
        foreach ($problems as $problem) {
            ProblemTranslation::factory()->create([
                'problem_id' => $problem->id,
            ]);
        }

        // Create a Questionnaire for the Project
        $questionnaire = Questionnaire::factory()->create([
            'project_id' => $project->id,
            'status_id' => QuestionnaireStatusLkp::PUBLISHED,
        ]);

        // Create a response for the Questionnaire
        $questionnaire_response = QuestionnaireResponse::factory()->create([
            'questionnaire_id' => $questionnaire->id,
            'user_id' => $user->id,
        ]);

        // When the user navigates in the Project Campaign page
        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'slug' => $project->slug]));

        // We need to assert that the page has the external link Call-to-Action (CTA) button
        $response->assertSee(__('questionnaire.invite_your_friends_to_answer'));
    }
}
