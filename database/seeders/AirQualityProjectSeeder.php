<?php

namespace Database\Seeders;

use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\CrowdSourcingProject\CrowdSourcingProjectTranslation;
use App\Repository\CrowdSourcingProject\CrowdSourcingProjectRepository;
use App\Repository\CrowdSourcingProject\CrowdSourcingProjectTranslationRepository;
use App\Utils\Helpers;
use Illuminate\Database\Seeder;

class AirQualityProjectSeeder extends Seeder {
    protected $projectRepository;
    protected $projectTranslationRepository;

    public function __construct(CrowdSourcingProjectRepository $crowdSourcingProjectRepository,
        CrowdSourcingProjectTranslationRepository $crowdSourcingProjectTranslationRepository) {
        $this->projectRepository = $crowdSourcingProjectRepository;
        $this->projectTranslationRepository = $crowdSourcingProjectTranslationRepository;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void {
        $project = [
            'id' => 4,
            'slug' => 'air-quality-europe',
            'external_url' => 'https://www.scify.gr/site/en/',
            'img_path' => '/images/projects/air-quality-europe/logo-bg.webp',
            'logo_path' => '/images/projects/air-quality-europe/logo.webp',
            'user_creator_id' => 1,
            'language_id' => 6,
            'should_send_email_after_questionnaire_response' => 1,
            'lp_primary_color' => '#707070',
            'lp_questionnaire_image_path' => '/images/projects/air-quality-europe/logo.webp',
            'lp_show_speak_up_btn' => 1,
            'sm_featured_img_path' => '/images/projects/air-quality-europe/logo.webp',
            'display_landing_page_banner' => 1,
            'status_id' => CrowdSourcingProjectStatusLkp::PUBLISHED,
        ];

        $project_translations = [
            [
                'id' => 6,
                'language_id' => 6,
                'project_id' => 4,
                'name' => 'Air Quality in Europe',
                'motto_title' => 'Please share with us your opinion on the air quality in Europe. Your voice matters!',
                'motto_subtitle' => 'You can make an impact! Share your opinion with us!',
                'description' => 'Lorem ipsum dolor site amet',
                'about' => '<p>Contribute to solving air quality problems in Athens and across Europe. Write points for and against the proposed solutions. Your contributions will be a valuable contribution to official policy to improve air quality in Athens and across Europe.</p>',
                'footer' => '<p style="font-size: 12px;">© SCIFY ' . now()->year . '&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Terms of use</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Privacy Policy</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Cookie Policy</a>',
                'sm_title' => 'Air Quality in Europe',
                'sm_description' => 'Please share with us your opinion on the air quality in Europe. Your voice matters!',
                'sm_keywords' => 'Social Media Keywords',
                'questionnaire_response_email_intro_text' => '<p>Thanks to your contribution we are one step closer to understanding the problem.<br></p>',
                'questionnaire_response_email_outro_text' => '<p>Thank you for your time and effort.<br></p>',
            ],
            [
                'id' => 7,
                'language_id' => 12,
                'project_id' => 4,
                'name' => 'Η Ποιότητα του Αέρα στην Ευρώπη',
                'motto_title' => 'Παρακαλούμε μοιραστείτε μαζί μας την άποψή σας για την ποιότητα του αέρα στην Ευρώπη. Η φωνή σας μετράει!',
                'motto_subtitle' => 'Μπορείς να κάνεις διαφορά! Μοιραστείτε την άποψή σας μαζί μας!',
                'description' => 'Lorem ipsum dolor site amet',
                'about' => '<p>Συμβάλλετε στην επίλυση των προβλημάτων ποιότητας του αέρα στην Αθήνα και σε όλη την Ευρώπη. Γράψτε επιχειρήματα υπέρ και κατά των προτεινόμενων λύσεων. Η συμβολή σας θα είναι πολύτιμη για τη διαμόρφωση επίσημης πολιτικής για τη βελτίωση της ποιότητας του αέρα στην Αθήνα και σε όλη την Ευρώπη.</p>',
                'footer' => '<p style="font-size: 12px;">© SCIFY ' . now()->year . '&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Πολιτική Ορθής Χρήσης</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Πολιτική Ιδιωτικότητας</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Πολιτική Cookies</a>',
                'sm_title' => 'Η Ποιότητα του Αέρα στην Ευρώπη',
                'sm_description' => 'Παρακαλούμε μοιραστείτε μαζί μας την άποψή σας για την ποιότητα του αέρα στην Ευρώπη. Η φωνή σας μετράει!',
                'sm_keywords' => 'Social Media Keywords',
                'questionnaire_response_email_intro_text' => '<p>Χάρη στη συνεισφορά σας είμαστε ένα βήμα πιο κοντά στην κατανόηση του προβλήματος.<br></p>',
                'questionnaire_response_email_outro_text' => '<p>Σας ευχαριστούμε για το χρόνο και την προσπάθειά σας.<br></p>',
            ],
        ];

        $project = $this->projectRepository->updateOrCreate(['id' => $project['id']],
            Helpers::getFilteredAttributes($project, (new CrowdSourcingProject)->getFillable()));
        if (app()->environment() !== 'testing') {
            echo "\nAdded Project: " . $project['name'] . ' with slug: ' . $project->slug . "\n";
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
