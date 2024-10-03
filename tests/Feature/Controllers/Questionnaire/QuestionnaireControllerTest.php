<?php

namespace Tests\Feature\Controllers\Questionnaire;

use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\BusinessLogicLayer\lkp\QuestionnaireStatusLkp;
use App\BusinessLogicLayer\lkp\UserRolesLkp;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Questionnaire\Questionnaire;
use App\Models\Questionnaire\QuestionnaireLanguage;
use App\Models\User;
use App\Models\UserRole;
use App\Utils\Translator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class QuestionnaireControllerTest extends TestCase {
    use RefreshDatabase;

    protected $seed = true;

    /**
     * @test
     */
    public function guestCannotSaveQuestionnaireStatus() {
        $response = $this->post(route('update-questionnaire-status'), [
            'questionnaire_id' => 1,
            'status_id' => 1,
            'comments' => 'Test comment',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('login', ['locale' => 'en']));
    }

    /**
     * @test
     */
    public function adminCanSaveQuestionnaireStatus() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $questionnaire = Questionnaire::factory()->create();

        $response = $this->post(route('update-questionnaire-status'), [
            'questionnaire_id' => $questionnaire->id,
            'status_id' => QuestionnaireStatusLkp::PUBLISHED,
            'comments' => 'Test comment',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('flash_message_success', 'The questionnaire status has been updated.');
        $this->assertDatabaseHas('questionnaires', [
            'id' => $questionnaire->id,
            'status_id' => QuestionnaireStatusLkp::PUBLISHED,
        ]);
    }

    /**
     * @test
     */
    public function adminCannotSaveQuestionnaireStatusWithInvalidQuestionnaireId() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->post(route('update-questionnaire-status'), [
            'questionnaire_id' => 'invalid',
            'status_id' => 'invalid',
            'comments' => '',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['status_id']);
    }

    /**
     * @test
     */
    public function adminCannotSaveQuestionnaireStatusWithInvalidData() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->post(route('update-questionnaire-status'), [
            'questionnaire_id' => 1,
            'status_id' => 'invalid',
            'comments' => '',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['status_id']);
    }

    /**
     * @test
     */
    public function guestCannotCreateQuestionnaire() {
        $response = $this->get(route('store-questionnaire'));

        $response->assertStatus(302);
        $response->assertRedirect(route('login', ['locale' => 'en']));
    }

    /**
     * @test
     */
    public function adminCanCreateQuestionnaire() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->get(route('create-questionnaire'));

        $response->assertStatus(200);
        $response->assertViewIs('questionnaire.create-edit');
    }

    /**
     * @test
     */
    public function adminCanStoreQuestionnaireWithValidData() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);
        $response = $this->post(route('store-questionnaire'), [
            'title' => 'Test Questionnaire',
            'description' => 'Test Description',
            'project_id' => 1,
            'prerequisite_order' => 1,
            'status_id' => 1,
            'type_id' => 1,
            'language' => 1,
            'goal' => 123,
            'questionnaire_json' => json_encode([
                'question1' => 'What is your name?',
                'question2' => 'What is your age?',
                'question3' => 'What?']),
            'statistics_page_visibility_lkp_id' => 1,
            'max_votes_num' => 5,
            'show_general_statistics' => true,
            'respondent_auth_required' => false,
            'show_file_type_questions_to_statistics_page_audience' => false,
            'lang_codes' => ['en', 'fr'],
            'content' => 'Test content',
            'project_ids' => [1],
        ]);

        $response->assertStatus(201);
        $questionnaire = Questionnaire::latest()->first();
        $this->assertDatabaseHas('questionnaires', [
            'id' => $questionnaire->id,
            'goal' => $questionnaire->goal,
            'max_votes_num' => $questionnaire->max_votes_num,
            'show_general_statistics' => $questionnaire->show_general_statistics,
        ]);
    }

    /**
     * @test
     */
    public function adminCannotStoreQuestionnaireWithInvalidData() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->post(route('store-questionnaire'), [
            'title' => 'Test Questionnaire',
            'description' => 'Test Description',
            'project_id' => 'invalid',
            'prerequisite_order' => 1,
            'status_id' => 1,
            'type_id' => 1,
            'language' => 1,
            'goal' => 123,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['statistics_page_visibility_lkp_id', 'lang_codes', 'content', 'project_ids']);
    }

    /**
     * @test
     */
    /**
     * @test
     */
    public function guestCannotUpdateQuestionnaire() {
        $questionnaire = Questionnaire::factory()->create();

        $response = $this->post(route('update-questionnaire', ['id' => $questionnaire->id]), [
            'title' => 'Test Questionnaire',
            'description' => 'Test Description',
            'project_id' => 1,
            'prerequisite_order' => 1,
            'status_id' => 1,
            'type_id' => 1,
            'language' => 1,
            'goal' => 123,
            'questionnaire_json' => json_encode([
                'question1' => 'What is your name?',
                'question2' => 'What is your age?',
                'question3' => 'What?']),
            'statistics_page_visibility_lkp_id' => 1,
            'max_votes_num' => 5,
            'show_general_statistics' => true,
            'respondent_auth_required' => false,
            'show_file_type_questions_to_statistics_page_audience' => false,
            'lang_codes' => ['en', 'fr'],
            'content' => 'Test content',
            'project_ids' => [1],
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('login', ['locale' => 'en']));
    }

    /**
     * @test
     */
    /**
     * @test
     */
    public function adminCanUpdateQuestionnaireWithValidData() {
        $questionnaire = Questionnaire::factory()->create();
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);
        $response = $this->post(route('update-questionnaire', ['id' => $questionnaire->id]), [
            'title' => 'Test Questionnaire new',
            'description' => 'Test Description new',
            'project_id' => 1,
            'prerequisite_order' => 1,
            'status_id' => 1,
            'type_id' => 1,
            'language' => 1,
            'goal' => 10,
            'questionnaire_json' => json_encode([
                'question1' => 'What is your name?',
                'question2' => 'What is your age?',
                'question3' => 'What?']),
            'statistics_page_visibility_lkp_id' => 1,
            'max_votes_num' => 5,
            'show_general_statistics' => 1,
            'respondent_auth_required' => false,
            'show_file_type_questions_to_statistics_page_audience' => false,
            'lang_codes' => ['en', 'fr'],
            'content' => 'Test content',
            'project_ids' => [1],
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('questionnaires', [
            'id' => $questionnaire->id,
            'goal' => $questionnaire->goal,
            'max_votes_num' => $questionnaire->max_votes_num,
            'show_general_statistics' => $questionnaire->show_general_statistics,
        ]);

        $this->assertDatabaseHas('questionnaire_fields_translations', [
            'questionnaire_id' => $questionnaire->id,
            'title' => 'Test Questionnaire new',
            'description' => 'Test Description new',
        ]);
    }

    /**
     * @test
     */
    public function adminCannotUpdateQuestionnaireWithInvalidData() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $questionnaire = Questionnaire::factory()->create();

        $response = $this->post(route('update-questionnaire', ['id' => $questionnaire->id]), [
            'title' => 'Test Questionnaire',
            'description' => 'Test Description',
            'project_id' => 'invalid',
            'prerequisite_order' => 1,
            'status_id' => 1,
            'type_id' => 1,
            'language' => 1,
            'goal' => 123,
            'content' => 'Test content',
            'project_ids' => [1],
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['statistics_page_visibility_lkp_id', 'lang_codes']);
    }

    /**
     * @test
     */
    public function guestCannotTranslateQuestionnaire() {
        $response = $this->post(route('questionnaire.translate'), [
            'questionnaire_json' => '{}',
            'locales' => ['en', 'fr'],
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('login', ['locale' => 'en']));
    }

    /**
     * @test
     */
    public function adminCanTranslateQuestionnaireWithValidData() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        // Create a mock instance of the Translator class
        $translatorMock = Mockery::mock(Translator::class);
        $translatorMock->shouldReceive('translateTexts')
            ->andReturn([
                ['text' => 'What is your opinion on Democracy in EU?'],
                ['text' => 'Please share your opinion with us!'],
                ['text' => 'Have you ever participated in Democratic processes about the EU?'],
                ['text' => 'Yes, more than once'],
                ['text' => 'I am not sure'],
                ['text' => 'Never'],
                ['text' => 'How could Democracy in EU improve?'],
            ]);

        // Inject the mock into the service container
        $this->app->instance(Translator::class, $translatorMock);

        $response = $this->post(route('questionnaire.translate'), [
            'questionnaire_json' => '{ "title": { "default": "What is your opinion on Democracy in EU?", "gr": "Ποιά είναι η άποψή σας για τις Εκλογές στην ΕΕ;" }, "description": { "default": "Please share your opinion with us!", "gr": "Μοιραστείτε μαζί μας τη γνώμη σας!" }, "logoPosition": "right", "pages": [ { "name": "page1", "elements": [ { "type": "radiogroup", "name": "question2", "title": { "default": "Have you ever participated in Democratic processes about the EU?", "gr": "Έχετε συμμετάσχει ποτέ σε δημοκρατικές διαδικασίες που αφορούν την ΕΕ;" }, "choices": [ { "value": "item1", "text": { "default": "Yes, more than once", "gr": "Ναι, περισσότερες από μια φορές" } }, { "value": "item2", "text": { "default": "I am not sure", "gr": "Δεν είμαι σίγουρος/η" } }, { "value": "item3", "text": { "default": "Never", "gr": "Ποτέ" } } ] }, { "type": "comment", "name": "question3", "title": { "default": "How could Democracy in EU improve?", "gr": "Πώς θα μπορούσε να βελτιωθεί η Δημοκρατία στην ΕΕ;" } } ] } ] }',
            'locales' => ['en', 'fr'],
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['translation']);
    }

    /**
     * @test
     */
    public function adminCannotTranslateQuestionnaireWithInvalidData() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->post(route('questionnaire.translate'), [
            'questionnaire_json' => '',
            'locales' => 'invalid',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['questionnaire_json', 'locales']);
    }

    /**
     * @test
     */
    public function getLanguagesForQuestionnaire() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->get(route('questionnaire.languages', ['questionnaire_id' => 1]));

        $response->assertStatus(200);
        $response->assertJsonStructure(['questionnaire_languages']);
    }

    /**
     * @test
     */
    public function adminCanMarkQuestionnaireTranslations() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $questionnaire = Questionnaire::factory()->create();

        // also create some questionnaire languages for this questionnaire, through the questionnaire language factory
        $questionnaireLanguage = QuestionnaireLanguage::factory()->create([
            'questionnaire_id' => $questionnaire->id,
            'language_id' => 1,
            'human_approved' => 1,
            'color' => '#000000',
        ]);


        $response = $this->post(route('questionnaire.mark-translations'), [
            'questionnaire_id' => $questionnaire->id,
            'lang_ids_to_status' => [
                ['id' => 1, 'status' => true],
            ],
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    /**
     * @test
     */
    public function itCanShowQuestionnairePage() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        // create a project and a questionnaire with "active" status
        $project = CrowdSourcingProject::factory()->create([
            'status_id' => CrowdSourcingProjectStatusLkp::PUBLISHED,
        ]);
        $questionnaire = Questionnaire::factory()->create([
            'status_id' => QuestionnaireStatusLkp::PUBLISHED,
        ]);

        // Associate the project and questionnaire
        $project->questionnaires()->attach($questionnaire->id);

        // Check if the project and questionnaire exist in the database
        $this->assertDatabaseHas('crowd_sourcing_projects', ['id' => $project->id]);
        $this->assertDatabaseHas('questionnaires', ['id' => $questionnaire->id]);


        $response = $this->get(route('show-questionnaire-page', ['project' => $project->slug, 'questionnaire' => $questionnaire->id]));

        $response->assertStatus(200);
        $response->assertViewIs('questionnaire.questionnaire-page');
    }

    /**
     * @test
     */
    public function itCannotShowQuestionnairePageForNonPublishedQuestionnaire() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        // create a project and a questionnaire with "active" status
        $project = CrowdSourcingProject::factory()->create([
            'status_id' => CrowdSourcingProjectStatusLkp::PUBLISHED,
        ]);
        $questionnaire = Questionnaire::factory()->create([
            'status_id' => QuestionnaireStatusLkp::DRAFT,
        ]);

        // Associate the project and questionnaire
        $project->questionnaires()->attach($questionnaire->id);

        // Check if the project and questionnaire exist in the database
        $this->assertDatabaseHas('crowd_sourcing_projects', ['id' => $project->id]);
        $this->assertDatabaseHas('questionnaires', ['id' => $questionnaire->id]);


        $response = $this->get(route('show-questionnaire-page', ['project' => $project->slug, 'questionnaire' => $questionnaire->id]));

        $response->assertStatus(302);
        $response->assertSessionHas('flash_message_error', 'The questionnaire is not active.');
    }

    /**
     * @test
     */
    public function itCannotShowQuestionnairePageForNonPublishedProject() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        // create a project and a questionnaire with "active" status
        $project = CrowdSourcingProject::factory()->create([
            'status_id' => CrowdSourcingProjectStatusLkp::DRAFT,
        ]);
        $questionnaire = Questionnaire::factory()->create([
            'status_id' => QuestionnaireStatusLkp::PUBLISHED,
        ]);

        // Associate the project and questionnaire
        $project->questionnaires()->attach($questionnaire->id);

        // Check if the project and questionnaire exist in the database
        $this->assertDatabaseHas('crowd_sourcing_projects', ['id' => $project->id]);
        $this->assertDatabaseHas('questionnaires', ['id' => $questionnaire->id]);


        $response = $this->get(route('show-questionnaire-page', ['project' => $project->slug, 'questionnaire' => $questionnaire->id]));

        $response->assertStatus(302);
        $response->assertSessionHas('flash_message_error', 'The project is not active.');
    }
}
