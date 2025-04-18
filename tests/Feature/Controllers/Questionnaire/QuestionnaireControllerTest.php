<?php

namespace Tests\Feature\Controllers\Questionnaire;

use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\BusinessLogicLayer\lkp\QuestionnaireStatusLkp;
use App\BusinessLogicLayer\lkp\UserRolesLkp;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Questionnaire\Questionnaire;
use App\Models\Questionnaire\QuestionnaireLanguage;
use App\Models\User\User;
use App\Models\User\UserRole;
use App\Utils\Translator;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class QuestionnaireControllerTest extends TestCase {
    #[Test]
    public function guest_cannot_save_questionnaire_status(): void {
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('questionnaire.update-status', ['locale' => 'en']), [
                'questionnaire_id' => 1,
                'status_id' => 1,
                'comments' => 'Test comment',
            ]);

        $response->assertStatus(302);
        $response->assertRedirectContains(route('login', ['locale' => 'en']));
    }

    #[Test]
    public function admin_can_save_questionnaire_status(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $questionnaire = Questionnaire::factory()->create();

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('questionnaire.update-status', ['locale' => 'en']), [
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

    #[Test]
    public function admin_cannot_save_questionnaire_status_with_invalid_questionnaire_id(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('questionnaire.update-status', ['locale' => 'en']), [
                'questionnaire_id' => 'invalid',
                'status_id' => 'invalid',
                'comments' => '',
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['status_id']);
    }

    #[Test]
    public function admin_cannot_save_questionnaire_status_with_invalid_data(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('questionnaire.update-status', ['locale' => 'en']), [
                'questionnaire_id' => 1,
                'status_id' => 'invalid',
                'comments' => '',
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['status_id']);
    }

    #[Test]
    public function admin_can_create_questionnaire(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->get(route('create-questionnaire', ['locale' => 'en']));

        $response->assertStatus(200);
        $response->assertViewIs('backoffice.management.questionnaire.create-edit');
    }

    #[Test]
    public function admin_can_store_questionnaire_with_valid_data(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('api.questionnaire.store'), [
                'title' => 'Test Questionnaire',
                'description' => 'Test Description',
                'project_id' => 1,
                'prerequisite_order' => 1,
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

    #[Test]
    public function admin_cannot_store_questionnaire_with_invalid_data(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('api.questionnaire.store'), [
                'title' => 'Test Questionnaire',
                'description' => 'Test Description',
                'project_id' => 'invalid',
                'prerequisite_order' => 1,
                'type_id' => 1,
                'language' => 1,
                'goal' => 123,
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['statistics_page_visibility_lkp_id', 'content', 'project_ids']);
    }

    #[Test]
    public function guest_cannot_update_questionnaire(): void {
        $questionnaire = Questionnaire::factory()->create();

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('api.questionnaire.update', ['id' => $questionnaire->id]), [
                'title' => 'Test Questionnaire',
                'description' => 'Test Description',
                'project_id' => 1,
                'prerequisite_order' => 1,
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
        $response->assertRedirectContains(route('login', ['locale' => 'en']));
    }

    #[Test]
    public function admin_can_update_questionnaire_with_valid_data(): void {
        $questionnaire = Questionnaire::factory()->create();
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('api.questionnaire.update', ['id' => $questionnaire->id]), [
                'title' => 'Test Questionnaire new',
                'description' => 'Test Description new',
                'project_id' => 1,
                'prerequisite_order' => 1,
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

    #[Test]
    public function admin_cannot_update_questionnaire_with_invalid_data(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $questionnaire = Questionnaire::factory()->create();

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('api.questionnaire.update', ['id' => $questionnaire->id]), [
                'title' => 'Test Questionnaire',
                'description' => 'Test Description',
                'project_id' => 'invalid',
                'prerequisite_order' => 1,
                'type_id' => 1,
                'language' => 1,
                'goal' => 123,
                'content' => 'Test content',
                'project_ids' => [1],
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['statistics_page_visibility_lkp_id']);
    }

    #[Test]
    public function guest_cannot_translate_questionnaire(): void {
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('api.questionnaire.translation.store'), [
                'questionnaire_json' => '{}',
                'locales' => ['en', 'fr'],
            ]);

        $response->assertStatus(302);
        $response->assertRedirectContains(route('login', ['locale' => 'en']));
    }

    #[Test]
    public function admin_can_translate_questionnaire_with_valid_data(): void {
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

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('api.questionnaire.translation.store'), [
                'questionnaire_json' => '{ "title": { "default": "What is your opinion on Democracy in EU?", "gr": "Ποιά είναι η άποψή σας για τις Εκλογές στην ΕΕ;" }, "description": { "default": "Please share your opinion with us!", "gr": "Μοιραστείτε μαζί μας τη γνώμη σας!" }, "logoPosition": "right", "pages": [ { "name": "page1", "elements": [ { "type": "radiogroup", "name": "question2", "title": { "default": "Have you ever participated in Democratic processes about the EU?", "gr": "Έχετε συμμετάσχει ποτέ σε δημοκρατικές διαδικασίες που αφορούν την ΕΕ;" }, "choices": [ { "value": "item1", "text": { "default": "Yes, more than once", "gr": "Ναι, περισσότερες από μια φορές" } }, { "value": "item2", "text": { "default": "I am not sure", "gr": "Δεν είμαι σίγουρος/η" } }, { "value": "item3", "text": { "default": "Never", "gr": "Ποτέ" } } ] }, { "type": "comment", "name": "question3", "title": { "default": "How could Democracy in EU improve?", "gr": "Πώς θα μπορούσε να βελτιωθεί η Δημοκρατία στην ΕΕ;" } } ] } ] }',
                'locales' => ['en', 'fr'],
            ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['translation']);
    }

    #[Test]
    public function admin_cannot_translate_questionnaire_with_invalid_data(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('api.questionnaire.translation.store'), [
                'questionnaire_json' => '',
                'locales' => 'invalid',
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['questionnaire_json', 'locales']);
    }

    #[Test]
    public function get_languages_for_questionnaire(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->get(route('api.questionnaire.languages.get', ['questionnaire_id' => 1]));

        $response->assertStatus(200);
        $response->assertJsonStructure(['questionnaire_languages']);
    }

    #[Test]
    public function admin_can_mark_questionnaire_translations(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $questionnaire = Questionnaire::factory()->create();

        // also create some questionnaire languages for this questionnaire, through the questionnaire language factory
        QuestionnaireLanguage::factory()->create([
            'questionnaire_id' => $questionnaire->id,
            'language_id' => 1,
            'human_approved' => 1,
            'color' => '#000000',
        ]);


        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('api.questionnaire.translations.mark'), [
                'questionnaire_id' => $questionnaire->id,
                'lang_ids_to_status' => [
                    ['id' => 1, 'status' => true],
                ],
            ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    #[Test]
    public function it_can_show_questionnaire_page(): void {
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

        // create a default translation for the questionnaire
        $questionnaire->defaultFieldsTranslation()->create([
            'title' => 'Test Questionnaire',
            'description' => 'Test Description',
            'language_id' => 6,
        ]);

        // Associate the project and questionnaire
        $project->questionnaires()->attach($questionnaire->id);

        // Check if the project and questionnaire exist in the database
        $this->assertDatabaseHas('crowd_sourcing_projects', ['id' => $project->id]);
        $this->assertDatabaseHas('questionnaires', ['id' => $questionnaire->id]);


        $response = $this->get(route('show-questionnaire-page', ['locale' => 'en', 'project' => $project->slug, 'questionnaire' => $questionnaire->id]));

        $response->assertStatus(200);
        $response->assertViewIs('questionnaire.questionnaire-page');
    }

    #[Test]
    public function it_cannot_show_questionnaire_page_for_non_published_questionnaire(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::REGISTERED_USER]))
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


        $response = $this->get(route('show-questionnaire-page', ['locale' => 'en', 'project' => $project->slug, 'questionnaire' => $questionnaire->id]));

        $response->assertStatus(302);
        $response->assertSessionHas('flash_message_error', 'The questionnaire is not active.');
    }

    #[Test]
    public function it_cannot_show_questionnaire_page_for_non_published_project(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::REGISTERED_USER]))
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


        $response = $this->get(route('show-questionnaire-page', ['locale' => 'en', 'project' => $project->slug, 'questionnaire' => $questionnaire->id]));

        $response->assertStatus(302);
        $response->assertSessionHas('flash_message_error', 'The project is not active.');
    }
}
