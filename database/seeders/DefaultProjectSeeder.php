<?php

namespace Database\Seeders;

use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\CrowdSourcingProject\CrowdSourcingProjectTranslation;
use App\Repository\CrowdSourcingProject\CrowdSourcingProjectRepository;
use App\Repository\CrowdSourcingProject\CrowdSourcingProjectTranslationRepository;
use App\Utils\Helpers;
use Illuminate\Database\Seeder;

class DefaultProjectSeeder extends Seeder {
    protected $projectRepository;
    protected $projectTranslationRepository;

    public function __construct(CrowdSourcingProjectRepository $crowdSourcingProjectRepository,
        CrowdSourcingProjectTranslationRepository $crowdSourcingProjectTranslationRepository) {
        $this->projectRepository = $crowdSourcingProjectRepository;
        $this->projectTranslationRepository = $crowdSourcingProjectTranslationRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $data = [
            [
                'id' => 1,
                'slug' => 'european-elections',
                'external_url' => null,
                'img_path' => '/images/projects/european-elections/logo-bg.webp',
                'logo_path' => '/images/projects/european-elections/logo.webp',
                'user_creator_id' => 1,
                'language_id' => 6,
                'should_send_email_after_questionnaire_response' => 1,
                'lp_primary_color' => '#0069d9',
                'lp_btn_text_color_theme' => '#212529',
                'lp_questionnaire_image_path' => '/images/projects/european-elections/logo.webp',
                'lp_show_speak_up_btn' => 1,
                'sm_featured_img_path' => '/images/projects/european-elections/logo.webp',
                'display_landing_page_banner' => 0,
                'status_id' => CrowdSourcingProjectStatusLkp::PUBLISHED,
            ],
            [
                'id' => 2,
                'slug' => 'european-democracy',
                'external_url' => null,
                'img_path' => '/images/projects/european-democracy/logo-bg.webp',
                'logo_path' => '/images/projects/european-democracy/logo.webp',
                'user_creator_id' => 1,
                'language_id' => 6,
                'should_send_email_after_questionnaire_response' => 1,
                'lp_primary_color' => '#0069d9',
                'lp_btn_text_color_theme' => '#212529',
                'lp_questionnaire_image_path' => '/images/projects/european-democracy/logo.webp',
                'lp_show_speak_up_btn' => 1,
                'sm_featured_img_path' => '/images/projects/european-democracy/logo.webp',
                'display_landing_page_banner' => 0,
                'status_id' => CrowdSourcingProjectStatusLkp::PUBLISHED,
            ],
            [
                'id' => 3,
                'slug' => 'test-project',
                'external_url' => 'https://www.scify.gr/site/en/',
                'img_path' => '/images/projects/european-democracy/logo-bg.webp',
                'logo_path' => '/images/projects/european-democracy/logo.webp',
                'user_creator_id' => 1,
                'language_id' => 6,
                'should_send_email_after_questionnaire_response' => 1,
                'lp_primary_color' => '#0069d9',
                'lp_btn_text_color_theme' => '#212529',
                'lp_questionnaire_image_path' => '/images/projects/european-democracy/logo.webp',
                'lp_show_speak_up_btn' => 1,
                'sm_featured_img_path' => '/images/projects/european-democracy/logo.webp',
                'display_landing_page_banner' => 0,
                'status_id' => CrowdSourcingProjectStatusLkp::DRAFT,
            ],
        ];

        $project_translations = [
            [
                'id' => 1,
                'language_id' => 6,
                'project_id' => 1,
                'name' => 'European Elections',
                'motto_title' => 'Please share with us your opinion on the European Elections. Your voice matters!',
                'motto_subtitle' => 'European Elections are coming up! Share your opinion with us!',
                'description' => 'Lorem ipsum dolor site amet',
                'about' => '<p>The European Elections project serves as a demonstration mechanism for the various Crowdsourcing beneficial results and a showcase. <a href="https://www.scify.gr/site/en/">Learn more about our project.</a></p>',
                'footer' => '<p style="font-size: 12px;">© SCIFY ' . now()->year . '&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Terms of use</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Privacy Policy</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Cookie Policy</a>',
                'sm_title' => 'European Elections',
                'sm_description' => 'Please share with us your opinion on this important subject. Your voice matters!',
                'sm_keywords' => 'Social Media Keywords',
                'questionnaire_response_email_intro_text' => '<p>Thanks to your contribution we are one step closer to understanding the problem.<br></p>',
                'questionnaire_response_email_outro_text' => '<p>Thank you for your time and effort.<br></p>',
            ],
            [
                'id' => 2,
                'language_id' => 12,
                'project_id' => 1,
                'name' => 'Ευρωπαϊκές Εκλογές',
                'motto_title' => 'Παρακαλούμε μοιραστείτε μαζί μας την άποψή σας για τις Ευρωπαϊκές Εκλογές. Η φωνή σας μετράει!',
                'motto_subtitle' => 'Οι Ευρωπαϊκές Εκλογές πλησιάζουν! Μοιραστείτε την άποψή σας μαζί μας!',
                'description' => 'Lorem ipsum dolor site amet',
                'about' => '<p>Αυτό το έργο λειτουργεί ως μηχανισμός επίδειξης για τα διάφορα επωφελή αποτελέσματα του Crowdsourcing. <a href="https://www.scify.gr/site/en/">Μάθετε περισσότερα για το έργο μας.</a></p>',
                'footer' => '<p style="font-size: 12px;">© SCIFY ' . now()->year . '&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Πολιτική Ορθής Χρήσης</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Πολιτική Ιδιωτικότητας</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Πολιτική Cookies</a>',
                'sm_title' => 'Ευρωπαϊκές Εκλογέςt',
                'sm_description' => 'Παρακαλούμε μοιραστείτε μαζί μας την άποψή σας για τις Ευρωπαϊκές Εκλογές. Η φωνή σας μετράει!',
                'sm_keywords' => 'Social Media Keywords',
                'questionnaire_response_email_intro_text' => '<p>Χάρη στη συνεισφορά σας είμαστε ένα βήμα πιο κοντά στην κατανόηση του προβλήματος.<br></p>',
                'questionnaire_response_email_outro_text' => '<p>Σας ευχαριστούμε για το χρόνο και την προσπάθειά σας.<br></p>',
            ],

            [
                'id' => 3,
                'language_id' => 6,
                'project_id' => 2,
                'name' => 'European Democracy Project',
                'motto_title' => 'Please share with us your opinion on Democracy in Europe. Your voice matters!',
                'motto_subtitle' => 'European Democracy Subtitle',
                'description' => 'European Democracy is a project that aims to gather opinions on the current state of democracy in Europe.',
                'about' => '<p>The European Democracy Project serves as a demonstration mechanism for the various Crowdsourcing beneficial results and a showcase. <a href="https://www.scify.gr/site/en/">Learn more about our project.</a></p>',
                'footer' => '<p style="font-size: 12px;">© SCIFY ' . now()->year . '&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Terms of use</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Privacy Policy</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Cookie Policy</a>',
                'sm_title' => 'European Democracy Project',
                'sm_description' => 'Please share with us your opinion on Democracy in Europe. Your voice matters!',
                'sm_keywords' => 'Social Media Keywords',
                'questionnaire_response_email_intro_text' => '<p>Thanks to your contribution we are one step closer to understanding the problem.<br></p>',
                'questionnaire_response_email_outro_text' => '<p>Thank you for your time and effort.<br></p>',
            ],
            [
                'id' => 4,
                'language_id' => 12,
                'project_id' => 2,
                'name' => 'Δημοκρατία στην Ευρώπη',
                'motto_title' => 'Παρακαλούμε μοιραστείτε μαζί μας την άποψή σας για τη Δημοκρατία στην Ευρώπη. Η φωνή σας μετράει!',
                'motto_subtitle' => 'Δημοκρατία στην Ευρώπη - Μια Σύγχρονη Προσέγγιση',
                'description' => 'Η Δημοκρατία στην Ευρώπη είναι ένα έργο που στοχεύει στη συγκέντρωση απόψεων για την τρέχουσα κατάσταση της δημοκρατίας στην Ευρώπη.',
                'about' => '<p>Το Έργο Δημοκρατία στην Ευρώπη λειτουργεί ως μηχανισμός επίδειξης για τα διάφορα επωφελή αποτελέσματα του Crowdsourcing. <a href="https://www.scify.gr/site/en/">Μάθετε περισσότερα για το έργο μας.</a></p>',
                'footer' => '<p style="font-size: 12px;">© SCIFY ' . now()->year . '&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Πολιτική Ορθής Χρήσης</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Πολιτική Ιδιωτικότητας</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Πολιτική Cookies</a>',
                'sm_title' => 'Δημοκρατία στην Ευρώπη',
                'sm_description' => 'Παρακαλούμε μοιραστείτε μαζί μας την άποψή σας για τη Δημοκρατία στην Ευρώπη. Η φωνή σας μετράει!',
                'sm_keywords' => 'Social Media Keywords',
                'questionnaire_response_email_intro_text' => '<p>Χάρη στη συνεισφορά σας είμαστε ένα βήμα πιο κοντά στην κατανόηση του προβλήματος.<br></p>',
                'questionnaire_response_email_outro_text' => '<p>Σας ευχαριστούμε για το χρόνο και την προσπάθειά σας.<br></p>',

            ],
            [
                'id' => 5,
                'language_id' => 6,
                'project_id' => 3,
                'name' => 'Test Project',
                'motto_title' => 'Please share with us your opinion on thie matter. Your voice matters!',
                'motto_subtitle' => 'Test Project! Share your opinion with us!',
                'description' => 'Lorem ipsum dolor site amet',
                'about' => '<p>The European Elections project serves as a demonstration mechanism for the various Crowdsourcing beneficial results and a showcase. <a href="https://www.scify.gr/site/en/">Learn more about our project.</a></p>',
                'footer' => '<p style="font-size: 12px;">© SCIFY ' . now()->year . '&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Terms of use</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Privacy Policy</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Cookie Policy</a>',
                'sm_title' => 'European Elections',
                'sm_description' => 'Please share with us your opinion on this important subject. Your voice matters!',
                'sm_keywords' => 'Social Media Keywords',
                'questionnaire_response_email_intro_text' => '<p>Thanks to your contribution we are one step closer to understanding the problem.<br></p>',
                'questionnaire_response_email_outro_text' => '<p>Thank you for your time and effort.<br></p>',
            ],
        ];

        foreach ($data as $project) {
            $project = $this->projectRepository->updateOrCreate(['id' => $project['id']],
                Helpers::getFilteredAttributes($project, (new CrowdSourcingProject)->getFillable()));
            if (app()->environment() !== 'testing') {
                echo "\nAdded Project: " . $project['name'] . ' with slug: ' . $project->slug . "\n";
            }
        }

        foreach ($project_translations as $project_translation) {
            $this->projectTranslationRepository->updateOrCreate(['id' => $project_translation['id']],
                Helpers::getFilteredAttributes($project_translation, (new CrowdSourcingProjectTranslation)->getFillable()));
            if (app()->environment() !== 'testing') {
                echo "\nAdded Project Translation: " . $project_translation['name'] . ' with id: ' . $project_translation['id'] . "\n";
            }
        }
    }
}
