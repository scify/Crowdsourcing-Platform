<?php

namespace Database\Seeders;

use App\BusinessLogicLayer\lkp\QuestionnaireTypeLkp;
use App\Repository\CrowdSourcingProject\CrowdSourcingProjectQuestionnaireRepository;
use App\Repository\Questionnaire\QuestionnaireLanguageRepository;
use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\QuestionnaireTranslationRepository;
use Illuminate\Database\Seeder;

class QuestionnaireSeeder extends Seeder {
    protected QuestionnaireRepository $questionnaireRepository;
    protected QuestionnaireTranslationRepository $questionnaireTranslationRepository;
    protected QuestionnaireLanguageRepository $questionnaireLanguageRepository;
    protected CrowdSourcingProjectQuestionnaireRepository $crowdSourcingProjectQuestionnaireRepository;

    public function __construct(QuestionnaireRepository $questionnaireRepository,
        QuestionnaireTranslationRepository $questionnaireTranslationRepository,
        QuestionnaireLanguageRepository $questionnaireLanguageRepository,
        CrowdSourcingProjectQuestionnaireRepository $crowdSourcingProjectQuestionnaireRepository) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->questionnaireTranslationRepository = $questionnaireTranslationRepository;
        $this->questionnaireLanguageRepository = $questionnaireLanguageRepository;
        $this->crowdSourcingProjectQuestionnaireRepository = $crowdSourcingProjectQuestionnaireRepository;
    }

    public function run() {
        $questionnaires = [
            [
                'id' => 1,
                'project_id' => 1,
                'type_id' => 1,
                'status_id' => QuestionnaireTypeLkp::MAIN_QUESTIONNAIRE,
                'default_language_id' => 6,
                'goal' => 100,
                'max_votes_num' => 10,
                'statistics_page_visibility_lkp_id' => 1,
                'show_general_statistics' => 1,
                'show_file_type_questions_to_statistics_page_audience' => 1,
                'respondent_auth_required' => 0,
                'questionnaire_json' => '{ "title": { "default": "What is your opinion on Elections in EU?", "gr": "Ποιά είναι η άποψή σας για τις Εκλογές στην ΕΕ;" }, "description": { "default": "Please share your opionion with us!", "gr": "Μοιραστείτε μαζί μας τη γνώμη σας!" }, "logoPosition": "right", "pages": [ { "name": "page1", "elements": [ { "type": "radiogroup", "name": "question2", "title": { "default": "What is your opinion on Elections in EU?", "gr": "Ποιά είναι η άποψή σας για τις Εκλογές στην ΕΕ;" }, "choices": [ { "value": "item1", "text": { "default": "I always vote", "gr": "Ψηφίζω πάντοτε" } }, { "value": "item2", "text": { "default": "I did not vote in the latest elections", "gr": "Δεν ψήφισα στις πρόσφατες εκλογές" } }, { "value": "item3", "text": { "default": "I have never voted", "gr": "Δεν έχω ψηφίσει ποτέ" } } ] }, { "type": "comment", "name": "question3", "title": { "default": "How could the number of voters increase?", "gr": "Πώς θα μπορούσε να αυξηθεί η συμμετοχή;" } } ] } ] }',
            ],
            [
                'id' => 2,
                'project_id' => 2,
                'type_id' => 1,
                'status_id' => QuestionnaireTypeLkp::MAIN_QUESTIONNAIRE,
                'default_language_id' => 6,
                'goal' => 50,
                'max_votes_num' => 5,
                'statistics_page_visibility_lkp_id' => 1,
                'show_general_statistics' => 1,
                'show_file_type_questions_to_statistics_page_audience' => 1,
                'respondent_auth_required' => 0,
                'questionnaire_json' => '{ "title": { "default": "What is your opinion on Democracy in EU?", "gr": "Ποιά είναι η άποψή σας για τις Εκλογές στην ΕΕ;" }, "description": { "default": "Please share your opionion with us!", "gr": "Μοιραστείτε μαζί μας τη γνώμη σας!" }, "logoPosition": "right", "pages": [ { "name": "page1", "elements": [ { "type": "radiogroup", "name": "question2", "title": { "default": "Have you ever participated in Democratic processes about the EU?", "gr": "Έχετε συμμετάσχει ποτέ σε δημοκρατικές διαδικασίες που αφορούν την ΕΕ;" }, "choices": [ { "value": "item1", "text": { "default": "Yes, more than once", "gr": "Ναι, περισσότερες από μια φορές" } }, { "value": "item2", "text": { "default": "I am not sure", "gr": "Δεν είμαι σίγουρος/η" } }, { "value": "item3", "text": { "default": "Never", "gr": "Ποτέ" } } ] }, { "type": "comment", "name": "question3", "title": { "default": "How could Democracy in EU improve?", "gr": "Πώς θα μπορούσε να βελτιωθεί η Δημοκρατία στην ΕΕ;" } } ] } ] }',
            ],
        ];

        $questionnaire_fields_translations = [
            [
                'questionnaire_id' => 1,
                'language_id' => 6,
                'title' => 'What is your opinion on the Elections in EU?',
                'description' => 'Please share your opinion about the Elections in EU!',
            ],
            [
                'questionnaire_id' => 1,
                'language_id' => 12,
                'title' => 'Ποιά είναι η άποψή σας για τις Εκλογές στην ΕΕ;',
                'description' => 'Μοιραστείτε μαζί μας τη γνώμη σας για τις Εκλογές στην ΕΕ!',
            ],
            [
                'questionnaire_id' => 2,
                'language_id' => 6,
                'title' => 'What is your opinion on Democracy in EU?',
                'description' => 'Please share your opinion about the Democracy in EU!',
            ],
            [
                'questionnaire_id' => 2,
                'language_id' => 12,
                'title' => 'Ποιά είναι η άποψή σας για τη Δημοκρατία στην ΕΕ;',
                'description' => 'Μοιραστείτε μαζί μας τη γνώμη σας για τη Δημοκρατία στην ΕΕ!',
            ],
        ];

        foreach ($questionnaires as $questionnaire) {
            $this->questionnaireRepository->updateOrCreate(['id' => $questionnaire['id']], $questionnaire);
            $this->crowdSourcingProjectQuestionnaireRepository->updateOrCreate([
                'project_id' => $questionnaire['project_id'],
                'questionnaire_id' => $questionnaire['id'],
            ], [
                'project_id' => $questionnaire['project_id'],
                'questionnaire_id' => $questionnaire['id'],
            ]);
            if (app()->environment() !== 'testing') {
                echo "\nAdded Questionnaire: " . $questionnaire['id'] . "\n";
            }
        }

        foreach ($questionnaire_fields_translations as $questionnaire_fields_translation) {
            $this->questionnaireLanguageRepository->updateOrCreate(
                ['language_id' => $questionnaire_fields_translation['language_id'], 'questionnaire_id' => $questionnaire_fields_translation['questionnaire_id']], [
                    'questionnaire_id' => $questionnaire_fields_translation['questionnaire_id'],
                    'language_id' => $questionnaire_fields_translation['language_id'],
                    'human_approved' => 1,
                ]);

            $this->questionnaireTranslationRepository->updateOrCreate([
                'questionnaire_id' => $questionnaire_fields_translation['questionnaire_id'],
                'language_id' => $questionnaire_fields_translation['language_id'],
            ], $questionnaire_fields_translation);
            if (app()->environment() !== 'testing') {
                echo "\nAdded Questionnaire Translation for questionnaire: " . $questionnaire_fields_translation['questionnaire_id'] . ' and language: ' . $questionnaire_fields_translation['language_id'] . "\n";
            }
        }
    }
}
