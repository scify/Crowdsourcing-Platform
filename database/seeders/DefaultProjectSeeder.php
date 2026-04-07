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
     */
    public function run(): void {
        $data = [
            [
                'id' => 1,
                'slug' => 'climate-action-survey',
                'external_url' => null,
                'img_path' => '/images/projects/climate-action-survey/logo-bg.webp',
                'logo_path' => '/images/projects/climate-action-survey/logo.webp',
                'user_creator_id' => 2,
                'language_id' => 6,
                'should_send_email_after_questionnaire_response' => 1,
                'lp_primary_color' => '#2d7a4f',
                'lp_btn_text_color_theme' => 'light',
                'lp_questionnaire_img_path' => '/images/projects/climate-action-survey/logo-bg.webp',
                'lp_show_speak_up_btn' => 0,
                'sm_featured_img_path' => '/images/projects/climate-action-survey/logo.webp',
                'display_landing_page_banner' => 1,
                'solution_submission_open' => 0,
                'status_id' => CrowdSourcingProjectStatusLkp::PUBLISHED,
            ],
            [
                'id' => 2,
                'slug' => 'urban-innovation-hub',
                'external_url' => null,
                'img_path' => '/images/projects/urban-innovation-hub/logo-bg.webp',
                'logo_path' => '/images/projects/urban-innovation-hub/logo.webp',
                'user_creator_id' => 2,
                'language_id' => 6,
                'should_send_email_after_questionnaire_response' => 0,
                'lp_primary_color' => '#e67e22',
                'lp_btn_text_color_theme' => 'light',
                'lp_questionnaire_img_path' => '/images/projects/urban-innovation-hub/logo-bg.webp',
                'lp_show_speak_up_btn' => 1,
                'sm_featured_img_path' => '/images/projects/urban-innovation-hub/logo.webp',
                'display_landing_page_banner' => 0,
                'solution_submission_open' => 1,
                'max_votes_per_user_for_solutions' => 5,
                'status_id' => CrowdSourcingProjectStatusLkp::PUBLISHED,
            ],
            [
                'id' => 3,
                'slug' => 'digital-democracy',
                'external_url' => null,
                'img_path' => '/images/projects/digital-democracy/logo-bg.webp',
                'logo_path' => '/images/projects/digital-democracy/logo.webp',
                'user_creator_id' => 1,
                'language_id' => 6,
                'should_send_email_after_questionnaire_response' => 1,
                'lp_primary_color' => '#2980b9',
                'lp_btn_text_color_theme' => 'light',
                'lp_questionnaire_img_path' => '/images/projects/digital-democracy/logo-bg.webp',
                'lp_show_speak_up_btn' => 1,
                'sm_featured_img_path' => '/images/projects/digital-democracy/logo.webp',
                'display_landing_page_banner' => 1,
                'solution_submission_open' => 1,
                'max_votes_per_user_for_solutions' => 3,
                'status_id' => CrowdSourcingProjectStatusLkp::PUBLISHED,
            ],
            [
                'id' => 4,
                'slug' => 'smart-cities-2030',
                'external_url' => null,
                'img_path' => '/images/projects/smart-cities-2030/logo-bg.webp',
                'logo_path' => '/images/projects/smart-cities-2030/logo.webp',
                'user_creator_id' => 1,
                'language_id' => 6,
                'should_send_email_after_questionnaire_response' => 0,
                'lp_primary_color' => '#6c3483',
                'lp_btn_text_color_theme' => 'light',
                'lp_questionnaire_img_path' => '/images/projects/smart-cities-2030/logo-bg.webp',
                'lp_show_speak_up_btn' => 0,
                'sm_featured_img_path' => '/images/projects/smart-cities-2030/logo.webp',
                'display_landing_page_banner' => 0,
                'solution_submission_open' => 0,
                'status_id' => CrowdSourcingProjectStatusLkp::FINALIZED,
            ],
        ];

        $project_translations = [
            // Project 1 — Climate Action Survey — EN
            [
                'id' => 1,
                'language_id' => 6,
                'project_id' => 1,
                'name' => 'Climate Action Survey',
                'motto_title' => 'Help shape our city\'s climate response — your opinion matters!',
                'motto_subtitle' => 'Take 2 minutes to share your views on local climate priorities.',
                'description' => 'A citizen engagement initiative to gather opinions on local climate action measures.',
                'about' => '<p>The Climate Action Survey invites citizens to share their priorities for local environmental policy. Together we can build a greener, more sustainable city. <a href="https://www.scify.gr/site/en/">Learn more about our work.</a></p>',
                'footer' => '<p style="font-size: 12px;">© SCIFY ' . now()->year . '&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Terms of use</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Privacy Policy</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Cookie Policy</a>',
                'sm_title' => 'Climate Action Survey',
                'sm_description' => 'Help shape our city\'s climate response — your opinion matters!',
                'sm_keywords' => 'climate, environment, survey, citizen engagement',
                'banner_title' => 'Your Voice Counts',
                'banner_text' => 'Over 200 citizens have already responded. Join them!',
                'thank_you_message' => 'Thank you for contributing to our climate survey!',
                'questionnaire_response_email_intro_text' => '<p>Thanks to your contribution we are one step closer to building a sustainable future.<br></p>',
                'questionnaire_response_email_outro_text' => '<p>Thank you for your time and dedication to our community.<br></p>',
            ],
            // Project 1 — Climate Action Survey — GR
            [
                'id' => 2,
                'language_id' => 12,
                'project_id' => 1,
                'name' => 'Έρευνα Κλιματικής Δράσης',
                'motto_title' => 'Βοηθήστε να διαμορφωθεί η κλιματική πολιτική της πόλης — η γνώμη σας μετράει!',
                'motto_subtitle' => 'Αφιερώστε 2 λεπτά για να μοιραστείτε τις απόψεις σας για τις τοπικές κλιματικές προτεραιότητες.',
                'description' => 'Μια πρωτοβουλία συμμετοχής πολιτών για τη συλλογή απόψεων σχετικά με τα τοπικά μέτρα κλιματικής δράσης.',
                'about' => '<p>Η Έρευνα Κλιματικής Δράσης καλεί τους πολίτες να μοιραστούν τις προτεραιότητές τους για την τοπική περιβαλλοντική πολιτική. <a href="https://www.scify.gr/site/en/">Μάθετε περισσότερα για το έργο μας.</a></p>',
                'footer' => '<p style="font-size: 12px;">© SCIFY ' . now()->year . '&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Πολιτική Ορθής Χρήσης</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Πολιτική Ιδιωτικότητας</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Πολιτική Cookies</a>',
                'sm_title' => 'Έρευνα Κλιματικής Δράσης',
                'sm_description' => 'Βοηθήστε να διαμορφωθεί η κλιματική πολιτική της πόλης — η γνώμη σας μετράει!',
                'sm_keywords' => 'κλίμα, περιβάλλον, έρευνα, συμμετοχή πολιτών',
                'banner_title' => 'Η Φωνή σας Μετράει',
                'banner_text' => 'Πάνω από 200 πολίτες έχουν ήδη απαντήσει. Γίνετε κι εσείς μέρος!',
                'thank_you_message' => 'Ευχαριστούμε για τη συνεισφορά σας στην έρευνά μας για το κλίμα!',
                'questionnaire_response_email_intro_text' => '<p>Χάρη στη συνεισφορά σας είμαστε ένα βήμα πιο κοντά στη δημιουργία ενός βιώσιμου μέλλοντος.<br></p>',
                'questionnaire_response_email_outro_text' => '<p>Σας ευχαριστούμε για τον χρόνο και την αφοσίωσή σας στην κοινότητά μας.<br></p>',
            ],
            // Project 2 — Urban Innovation Hub — EN
            [
                'id' => 3,
                'language_id' => 6,
                'project_id' => 2,
                'name' => 'Urban Innovation Hub',
                'motto_title' => 'What urban challenges should our city tackle first?',
                'motto_subtitle' => 'Share problems, propose solutions, vote on the best ideas.',
                'description' => 'A platform for citizens to identify urban challenges and collectively crowdsource innovative solutions.',
                'about' => '<p>The Urban Innovation Hub empowers residents to surface the city\'s most pressing problems and collaboratively develop creative solutions. <a href="https://www.scify.gr/site/en/">Learn more about our approach.</a></p>',
                'footer' => '<p style="font-size: 12px;">© SCIFY ' . now()->year . '&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Terms of use</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Privacy Policy</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Cookie Policy</a>',
                'sm_title' => 'Urban Innovation Hub',
                'sm_description' => 'Share problems, propose solutions, vote on the best ideas for our city.',
                'sm_keywords' => 'urban, innovation, solutions, city, civic participation',
                'questionnaire_response_email_intro_text' => '<p>Thanks to your contribution we are one step closer to solving our city\'s challenges.<br></p>',
                'questionnaire_response_email_outro_text' => '<p>Thank you for your time and effort.<br></p>',
            ],
            // Project 2 — Urban Innovation Hub — GR
            [
                'id' => 4,
                'language_id' => 12,
                'project_id' => 2,
                'name' => 'Κέντρο Αστικής Καινοτομίας',
                'motto_title' => 'Ποιες αστικές προκλήσεις πρέπει η πόλη μας να αντιμετωπίσει πρώτα;',
                'motto_subtitle' => 'Μοιραστείτε προβλήματα, προτείνετε λύσεις, ψηφίστε τις καλύτερες ιδέες.',
                'description' => 'Μια πλατφόρμα για τους πολίτες να εντοπίζουν αστικές προκλήσεις και να αναπτύσσουν συλλογικά καινοτόμες λύσεις.',
                'about' => '<p>Το Κέντρο Αστικής Καινοτομίας δίνει τη δυνατότητα στους κατοίκους να αναδείξουν τα πιο επείγοντα προβλήματα της πόλης. <a href="https://www.scify.gr/site/en/">Μάθετε περισσότερα για την προσέγγισή μας.</a></p>',
                'footer' => '<p style="font-size: 12px;">© SCIFY ' . now()->year . '&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Πολιτική Ορθής Χρήσης</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Πολιτική Ιδιωτικότητας</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Πολιτική Cookies</a>',
                'sm_title' => 'Κέντρο Αστικής Καινοτομίας',
                'sm_description' => 'Μοιραστείτε προβλήματα, προτείνετε λύσεις, ψηφίστε τις καλύτερες ιδέες για την πόλη μας.',
                'sm_keywords' => 'αστικές λύσεις, καινοτομία, πόλη, συμμετοχή πολιτών',
                'questionnaire_response_email_intro_text' => '<p>Χάρη στη συνεισφορά σας είμαστε ένα βήμα πιο κοντά στην επίλυση των αστικών προκλήσεων.<br></p>',
                'questionnaire_response_email_outro_text' => '<p>Σας ευχαριστούμε για τον χρόνο και την προσπάθειά σας.<br></p>',
            ],
            // Project 3 — Digital Democracy — EN
            [
                'id' => 5,
                'language_id' => 6,
                'project_id' => 3,
                'name' => 'Digital Democracy Initiative',
                'motto_title' => 'How should digital tools reshape civic participation?',
                'motto_subtitle' => 'Join the conversation on e-democracy, open data, and digital governance.',
                'description' => 'A full-featured campaign exploring how technology can strengthen democratic participation at every level of governance.',
                'about' => '<p>The Digital Democracy Initiative combines citizen surveys and community ideation to shape the future of digital governance. Share your views and vote on the best proposals. <a href="https://www.scify.gr/site/en/">Learn more about our project.</a></p>',
                'footer' => '<p style="font-size: 12px;">© SCIFY ' . now()->year . '&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Terms of use</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Privacy Policy</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Cookie Policy</a>',
                'sm_title' => 'Digital Democracy Initiative',
                'sm_description' => 'How should digital tools reshape civic participation? Join the conversation.',
                'sm_keywords' => 'digital democracy, e-governance, civic participation, open data',
                'banner_title' => 'Shape the Future of Democracy',
                'banner_text' => 'Complete the survey and vote on community proposals below.',
                'questionnaire_response_email_intro_text' => '<p>Thanks to your contribution we are one step closer to understanding what digital democracy means to our community.<br></p>',
                'questionnaire_response_email_outro_text' => '<p>Thank you for your time and civic engagement.<br></p>',
            ],
            // Project 3 — Digital Democracy — GR
            [
                'id' => 6,
                'language_id' => 12,
                'project_id' => 3,
                'name' => 'Πρωτοβουλία Ψηφιακής Δημοκρατίας',
                'motto_title' => 'Πώς πρέπει τα ψηφιακά εργαλεία να αναμορφώσουν τη συμμετοχή των πολιτών;',
                'motto_subtitle' => 'Γίνετε μέρος της συζήτησης για την ηλεκτρονική δημοκρατία, τα ανοικτά δεδομένα και την ψηφιακή διακυβέρνηση.',
                'description' => 'Μια εκστρατεία που εξερευνά πώς η τεχνολογία μπορεί να ενισχύσει τη δημοκρατική συμμετοχή.',
                'about' => '<p>Η Πρωτοβουλία Ψηφιακής Δημοκρατίας συνδυάζει έρευνες πολιτών και ανοικτή διαβούλευση για τη διαμόρφωση του ψηφιακού μέλλοντος. <a href="https://www.scify.gr/site/en/">Μάθετε περισσότερα για το έργο μας.</a></p>',
                'footer' => '<p style="font-size: 12px;">© SCIFY ' . now()->year . '&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Πολιτική Ορθής Χρήσης</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Πολιτική Ιδιωτικότητας</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Πολιτική Cookies</a>',
                'sm_title' => 'Πρωτοβουλία Ψηφιακής Δημοκρατίας',
                'sm_description' => 'Πώς πρέπει τα ψηφιακά εργαλεία να αναμορφώσουν τη συμμετοχή των πολιτών;',
                'sm_keywords' => 'ψηφιακή δημοκρατία, ηλεκτρονική διακυβέρνηση, συμμετοχή πολιτών',
                'banner_title' => 'Διαμορφώστε το Μέλλον της Δημοκρατίας',
                'banner_text' => 'Συμπληρώστε την έρευνα και ψηφίστε στις κοινοτικές προτάσεις.',
                'questionnaire_response_email_intro_text' => '<p>Χάρη στη συνεισφορά σας είμαστε ένα βήμα πιο κοντά στην κατανόηση τι σημαίνει ψηφιακή δημοκρατία.<br></p>',
                'questionnaire_response_email_outro_text' => '<p>Σας ευχαριστούμε για τον χρόνο και τη συμμετοχή σας.<br></p>',
            ],
            // Project 4 — Smart Cities 2030 — EN
            [
                'id' => 7,
                'language_id' => 6,
                'project_id' => 4,
                'name' => 'Smart Cities 2030',
                'motto_title' => 'What does a smart city mean for our community? [Campaign Concluded]',
                'motto_subtitle' => 'This campaign has concluded. Browse the results and solutions below.',
                'description' => 'A completed campaign that gathered community visions on smart city technology and its impact on everyday urban life.',
                'about' => '<p>The Smart Cities 2030 campaign has successfully concluded with 187 citizen responses. Browse the collected insights, problems identified, and community-proposed solutions below. <a href="https://www.scify.gr/site/en/">Learn more about our work.</a></p>',
                'footer' => '<p style="font-size: 12px;">© SCIFY ' . now()->year . '&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Terms of use</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Privacy Policy</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Cookie Policy</a>',
                'sm_title' => 'Smart Cities 2030',
                'sm_description' => 'Explore the results of our Smart Cities 2030 community campaign.',
                'sm_keywords' => 'smart cities, IoT, urban technology, community vision',
                'questionnaire_response_email_intro_text' => '<p>Thanks to your contribution to the Smart Cities 2030 campaign.<br></p>',
                'questionnaire_response_email_outro_text' => '<p>Thank you for helping shape our community\'s vision for the future.<br></p>',
            ],
            // Project 4 — Smart Cities 2030 — GR
            [
                'id' => 8,
                'language_id' => 12,
                'project_id' => 4,
                'name' => 'Έξυπνες Πόλεις 2030',
                'motto_title' => 'Τι σημαίνει έξυπνη πόλη για την κοινότητά μας; [Η Εκστρατεία Ολοκληρώθηκε]',
                'motto_subtitle' => 'Αυτή η εκστρατεία έχει ολοκληρωθεί. Δείτε τα αποτελέσματα και τις λύσεις παρακάτω.',
                'description' => 'Μια ολοκληρωμένη εκστρατεία που συγκέντρωσε τις απόψεις της κοινότητας για την τεχνολογία έξυπνης πόλης.',
                'about' => '<p>Η εκστρατεία Έξυπνες Πόλεις 2030 ολοκληρώθηκε με επιτυχία με 187 συμμετέχοντες. <a href="https://www.scify.gr/site/en/">Μάθετε περισσότερα για το έργο μας.</a></p>',
                'footer' => '<p style="font-size: 12px;">© SCIFY ' . now()->year . '&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Πολιτική Ορθής Χρήσης</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Πολιτική Ιδιωτικότητας</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Πολιτική Cookies</a>',
                'sm_title' => 'Έξυπνες Πόλεις 2030',
                'sm_description' => 'Εξερευνήστε τα αποτελέσματα της εκστρατείας Έξυπνες Πόλεις 2030.',
                'sm_keywords' => 'έξυπνες πόλεις, IoT, αστική τεχνολογία, κοινοτική οπτική',
                'questionnaire_response_email_intro_text' => '<p>Χάρη στη συνεισφορά σας στην εκστρατεία Έξυπνες Πόλεις 2030.<br></p>',
                'questionnaire_response_email_outro_text' => '<p>Σας ευχαριστούμε που βοηθήσατε να διαμορφωθεί το όραμα της κοινότητάς μας για το μέλλον.<br></p>',
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
