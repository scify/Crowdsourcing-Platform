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
                'motto_title' => 'Βοηθήστε να διαμορφωθεί η κλιματική πολιτική — η γνώμη σας μετράει!',
                'motto_subtitle' => 'Αφιερώστε 2 λεπτά για να μοιραστείτε τις απόψεις σας για τις κλιματικές προτεραιότητες.',
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
            // Project 1 — Climate Action Survey — DE
            [
                'id' => 9,
                'language_id' => 11,
                'project_id' => 1,
                'name' => 'Klimaaktionsumfrage',
                'motto_title' => 'Helfen Sie, die Klimareaktion unserer Stadt zu gestalten — Ihre Meinung zählt!',
                'motto_subtitle' => 'Nehmen Sie sich 2 Minuten Zeit, um Ihre Ansichten zu lokalen Klimaprioritäten zu teilen.',
                'description' => 'Eine Bürgerengagement-Initiative zur Sammlung von Meinungen zu lokalen Klimaschutzmaßnahmen.',
                'about' => '<p>Die Klimaaktionsumfrage lädt Bürger ein, ihre Prioritäten für die lokale Umweltpolitik zu teilen. Gemeinsam können wir eine grünere, nachhaltigere Stadt aufbauen. <a href="https://www.scify.gr/site/en/">Erfahren Sie mehr über unsere Arbeit.</a></p>',
                'footer' => '<p style="font-size: 12px;">© SCIFY ' . now()->year . '&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Nutzungsbedingungen</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Datenschutzrichtlinie</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Cookie-Richtlinie</a>',
                'sm_title' => 'Klimaaktionsumfrage',
                'sm_description' => 'Helfen Sie, die Klimareaktion unserer Stadt zu gestalten — Ihre Meinung zählt!',
                'sm_keywords' => 'Klima, Umwelt, Umfrage, Bürgerengagement',
                'banner_title' => 'Ihre Stimme zählt',
                'banner_text' => 'Über 200 Bürger haben bereits geantwortet. Machen Sie mit!',
                'thank_you_message' => 'Vielen Dank für Ihren Beitrag zu unserer Klimaumfrage!',
                'questionnaire_response_email_intro_text' => '<p>Dank Ihres Beitrags sind wir einem nachhaltigen Zukunft einen Schritt näher.<br></p>',
                'questionnaire_response_email_outro_text' => '<p>Vielen Dank für Ihre Zeit und Ihr Engagement für unsere Gemeinschaft.<br></p>',
            ],
            // Project 1 — Climate Action Survey — ES
            [
                'id' => 10,
                'language_id' => 22,
                'project_id' => 1,
                'name' => 'Encuesta de Acción Climática',
                'motto_title' => '¡Ayuda a dar forma a la respuesta climática de nuestra ciudad — tu opinión importa!',
                'motto_subtitle' => 'Tómate 2 minutos para compartir tus puntos de vista sobre las prioridades climáticas locales.',
                'description' => 'Una iniciativa de participación ciudadana para recopilar opiniones sobre las medidas locales de acción climática.',
                'about' => '<p>La Encuesta de Acción Climática invita a los ciudadanos a compartir sus prioridades para la política ambiental local. Juntos podemos construir una ciudad más verde y sostenible. <a href="https://www.scify.gr/site/en/">Conoce más sobre nuestro trabajo.</a></p>',
                'footer' => '<p style="font-size: 12px;">© SCIFY ' . now()->year . '&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Términos de uso</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Política de privacidad</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Política de cookies</a>',
                'sm_title' => 'Encuesta de Acción Climática',
                'sm_description' => '¡Ayuda a dar forma a la respuesta climática de nuestra ciudad — tu opinión importa!',
                'sm_keywords' => 'clima, medio ambiente, encuesta, participación ciudadana',
                'banner_title' => 'Tu voz cuenta',
                'banner_text' => 'Más de 200 ciudadanos ya han respondido. ¡Únete a ellos!',
                'thank_you_message' => '¡Gracias por contribuir a nuestra encuesta climática!',
                'questionnaire_response_email_intro_text' => '<p>Gracias a tu contribución estamos un paso más cerca de construir un futuro sostenible.<br></p>',
                'questionnaire_response_email_outro_text' => '<p>Gracias por tu tiempo y dedicación a nuestra comunidad.<br></p>',
            ],
            // Project 1 — Climate Action Survey — FR
            [
                'id' => 11,
                'language_id' => 10,
                'project_id' => 1,
                'name' => 'Enquête sur l\'Action Climatique',
                'motto_title' => 'Aidez à façonner la réponse climatique de notre ville — votre opinion compte !',
                'motto_subtitle' => 'Prenez 2 minutes pour partager vos points de vue sur les priorités climatiques locales.',
                'description' => 'Une initiative de participation citoyenne pour recueillir des opinions sur les mesures locales d\'action climatique.',
                'about' => '<p>L\'Enquête sur l\'Action Climatique invite les citoyens à partager leurs priorités pour la politique environnementale locale. Ensemble, nous pouvons construire une ville plus verte et plus durable. <a href="https://www.scify.gr/site/en/">En savoir plus sur notre travail.</a></p>',
                'footer' => '<p style="font-size: 12px;">© SCIFY ' . now()->year . '&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Conditions d\'utilisation</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Politique de confidentialité</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Politique des cookies</a>',
                'sm_title' => 'Enquête sur l\'Action Climatique',
                'sm_description' => 'Aidez à façonner la réponse climatique de notre ville — votre opinion compte !',
                'sm_keywords' => 'climat, environnement, enquête, participation citoyenne',
                'banner_title' => 'Votre voix compte',
                'banner_text' => 'Plus de 200 citoyens ont déjà répondu. Rejoignez-les !',
                'thank_you_message' => 'Merci d\'avoir contribué à notre enquête climatique !',
                'questionnaire_response_email_intro_text' => '<p>Grâce à votre contribution, nous sommes un pas plus près de construire un avenir durable.<br></p>',
                'questionnaire_response_email_outro_text' => '<p>Merci pour votre temps et votre dévouement à notre communauté.<br></p>',
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
            // Project 2 — Urban Innovation Hub — DE
            [
                'id' => 12,
                'language_id' => 11,
                'project_id' => 2,
                'name' => 'Zentrum für Stadtinnovation',
                'motto_title' => 'Welche städtischen Herausforderungen sollte unsere Stadt zuerst angehen?',
                'motto_subtitle' => 'Probleme teilen, Lösungen vorschlagen, für die besten Ideen stimmen.',
                'description' => 'Eine Plattform für Bürger, um städtische Herausforderungen zu identifizieren und gemeinsam innovative Lösungen zu entwickeln.',
                'about' => '<p>Das Zentrum für Stadtinnovation befähigt die Bewohner, die dringendsten Probleme der Stadt aufzuzeigen und gemeinsam kreative Lösungen zu entwickeln. <a href="https://www.scify.gr/site/en/">Erfahren Sie mehr über unseren Ansatz.</a></p>',
                'footer' => '<p style="font-size: 12px;">© SCIFY ' . now()->year . '&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Nutzungsbedingungen</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Datenschutzrichtlinie</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Cookie-Richtlinie</a>',
                'sm_title' => 'Zentrum für Stadtinnovation',
                'sm_description' => 'Probleme teilen, Lösungen vorschlagen, für die besten Ideen für unsere Stadt stimmen.',
                'sm_keywords' => 'Stadtentwicklung, Innovation, Lösungen, Stadt, Bürgerbeteiligung',
                'questionnaire_response_email_intro_text' => '<p>Dank Ihres Beitrags sind wir einen Schritt näher daran, die Herausforderungen unserer Stadt zu lösen.<br></p>',
                'questionnaire_response_email_outro_text' => '<p>Vielen Dank für Ihre Zeit und Ihr Engagement.<br></p>',
            ],
            // Project 2 — Urban Innovation Hub — ES
            [
                'id' => 13,
                'language_id' => 22,
                'project_id' => 2,
                'name' => 'Centro de Innovación Urbana',
                'motto_title' => '¿Qué desafíos urbanos debería afrontar primero nuestra ciudad?',
                'motto_subtitle' => 'Comparte problemas, propone soluciones, vota las mejores ideas.',
                'description' => 'Una plataforma para que los ciudadanos identifiquen desafíos urbanos y desarrollen colectivamente soluciones innovadoras.',
                'about' => '<p>El Centro de Innovación Urbana empodera a los residentes para identificar los problemas más urgentes de la ciudad y desarrollar colaborativamente soluciones creativas. <a href="https://www.scify.gr/site/en/">Conoce más sobre nuestro enfoque.</a></p>',
                'footer' => '<p style="font-size: 12px;">© SCIFY ' . now()->year . '&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Términos de uso</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Política de privacidad</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Política de cookies</a>',
                'sm_title' => 'Centro de Innovación Urbana',
                'sm_description' => 'Comparte problemas, propone soluciones, vota las mejores ideas para nuestra ciudad.',
                'sm_keywords' => 'urbano, innovación, soluciones, ciudad, participación ciudadana',
                'questionnaire_response_email_intro_text' => '<p>Gracias a tu contribución estamos un paso más cerca de resolver los desafíos de nuestra ciudad.<br></p>',
                'questionnaire_response_email_outro_text' => '<p>Gracias por tu tiempo y esfuerzo.<br></p>',
            ],
            // Project 2 — Urban Innovation Hub — FR
            [
                'id' => 14,
                'language_id' => 10,
                'project_id' => 2,
                'name' => 'Hub d\'Innovation Urbaine',
                'motto_title' => 'Quels défis urbains notre ville devrait-elle relever en premier ?',
                'motto_subtitle' => 'Partagez des problèmes, proposez des solutions, votez pour les meilleures idées.',
                'description' => 'Une plateforme permettant aux citoyens d\'identifier les défis urbains et de développer collectivement des solutions innovantes.',
                'about' => '<p>Le Hub d\'Innovation Urbaine permet aux résidents de faire émerger les problèmes les plus urgents de la ville et de développer collaborativement des solutions créatives. <a href="https://www.scify.gr/site/en/">En savoir plus sur notre approche.</a></p>',
                'footer' => '<p style="font-size: 12px;">© SCIFY ' . now()->year . '&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Conditions d\'utilisation</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Politique de confidentialité</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Politique des cookies</a>',
                'sm_title' => 'Hub d\'Innovation Urbaine',
                'sm_description' => 'Partagez des problèmes, proposez des solutions, votez pour les meilleures idées pour notre ville.',
                'sm_keywords' => 'urbain, innovation, solutions, ville, participation citoyenne',
                'questionnaire_response_email_intro_text' => '<p>Grâce à votre contribution, nous sommes un pas plus près de résoudre les défis de notre ville.<br></p>',
                'questionnaire_response_email_outro_text' => '<p>Merci pour votre temps et vos efforts.<br></p>',
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
            // Project 3 — Digital Democracy — DE
            [
                'id' => 15,
                'language_id' => 11,
                'project_id' => 3,
                'name' => 'Initiative Digitale Demokratie',
                'motto_title' => 'Wie sollten digitale Werkzeuge die Bürgerbeteiligung neu gestalten?',
                'motto_subtitle' => 'Nehmen Sie an der Diskussion über E-Demokratie, offene Daten und digitale Verwaltung teil.',
                'description' => 'Eine umfangreiche Kampagne, die untersucht, wie Technologie die demokratische Beteiligung auf allen Ebenen der Verwaltung stärken kann.',
                'about' => '<p>Die Initiative Digitale Demokratie verbindet Bürgerbefragungen und Community-Ideenfindung, um die Zukunft der digitalen Verwaltung zu gestalten. Teilen Sie Ihre Ansichten und stimmen Sie für die besten Vorschläge. <a href="https://www.scify.gr/site/en/">Erfahren Sie mehr über unser Projekt.</a></p>',
                'footer' => '<p style="font-size: 12px;">© SCIFY ' . now()->year . '&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Nutzungsbedingungen</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Datenschutzrichtlinie</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Cookie-Richtlinie</a>',
                'sm_title' => 'Initiative Digitale Demokratie',
                'sm_description' => 'Wie sollten digitale Werkzeuge die Bürgerbeteiligung neu gestalten? Nehmen Sie an der Diskussion teil.',
                'sm_keywords' => 'digitale Demokratie, E-Government, Bürgerbeteiligung, offene Daten',
                'banner_title' => 'Gestalten Sie die Zukunft der Demokratie',
                'banner_text' => 'Nehmen Sie an der Umfrage teil und stimmen Sie unten über Gemeinschaftsvorschläge ab.',
                'questionnaire_response_email_intro_text' => '<p>Dank Ihres Beitrags sind wir einen Schritt näher daran, zu verstehen, was digitale Demokratie für unsere Gemeinschaft bedeutet.<br></p>',
                'questionnaire_response_email_outro_text' => '<p>Vielen Dank für Ihre Zeit und Ihr bürgerliches Engagement.<br></p>',
            ],
            // Project 3 — Digital Democracy — ES
            [
                'id' => 16,
                'language_id' => 22,
                'project_id' => 3,
                'name' => 'Iniciativa de Democracia Digital',
                'motto_title' => '¿Cómo deberían las herramientas digitales reformar la participación cívica?',
                'motto_subtitle' => 'Únete a la conversación sobre e-democracia, datos abiertos y gobernanza digital.',
                'description' => 'Una campaña completa que explora cómo la tecnología puede fortalecer la participación democrática en todos los niveles de gobernanza.',
                'about' => '<p>La Iniciativa de Democracia Digital combina encuestas ciudadanas e ideación comunitaria para dar forma al futuro de la gobernanza digital. Comparte tus puntos de vista y vota por las mejores propuestas. <a href="https://www.scify.gr/site/en/">Conoce más sobre nuestro proyecto.</a></p>',
                'footer' => '<p style="font-size: 12px;">© SCIFY ' . now()->year . '&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Términos de uso</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Política de privacidad</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Política de cookies</a>',
                'sm_title' => 'Iniciativa de Democracia Digital',
                'sm_description' => '¿Cómo deberían las herramientas digitales reformar la participación cívica? Únete a la conversación.',
                'sm_keywords' => 'democracia digital, e-gobernanza, participación cívica, datos abiertos',
                'banner_title' => 'Da forma al futuro de la democracia',
                'banner_text' => 'Completa la encuesta y vota las propuestas de la comunidad a continuación.',
                'questionnaire_response_email_intro_text' => '<p>Gracias a tu contribución estamos un paso más cerca de entender qué significa la democracia digital para nuestra comunidad.<br></p>',
                'questionnaire_response_email_outro_text' => '<p>Gracias por tu tiempo y tu participación cívica.<br></p>',
            ],
            // Project 3 — Digital Democracy — FR
            [
                'id' => 17,
                'language_id' => 10,
                'project_id' => 3,
                'name' => 'Initiative pour la Démocratie Numérique',
                'motto_title' => 'Comment les outils numériques devraient-ils remodeler la participation civique ?',
                'motto_subtitle' => 'Rejoignez la conversation sur la démocratie électronique, les données ouvertes et la gouvernance numérique.',
                'description' => 'Une campagne complète explorant comment la technologie peut renforcer la participation démocratique à tous les niveaux de gouvernance.',
                'about' => '<p>L\'Initiative pour la Démocratie Numérique combine des enquêtes citoyennes et une idéation communautaire pour façonner l\'avenir de la gouvernance numérique. Partagez vos points de vue et votez pour les meilleures propositions. <a href="https://www.scify.gr/site/en/">En savoir plus sur notre projet.</a></p>',
                'footer' => '<p style="font-size: 12px;">© SCIFY ' . now()->year . '&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Conditions d\'utilisation</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Politique de confidentialité</a>&nbsp;|&nbsp;
                    <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Politique des cookies</a>',
                'sm_title' => 'Initiative pour la Démocratie Numérique',
                'sm_description' => 'Comment les outils numériques devraient-ils remodeler la participation civique ? Rejoignez la conversation.',
                'sm_keywords' => 'démocratie numérique, e-gouvernance, participation civique, données ouvertes',
                'banner_title' => 'Façonnez l\'avenir de la démocratie',
                'banner_text' => 'Complétez l\'enquête et votez pour les propositions communautaires ci-dessous.',
                'questionnaire_response_email_intro_text' => '<p>Grâce à votre contribution, nous sommes un pas plus près de comprendre ce que la démocratie numérique signifie pour notre communauté.<br></p>',
                'questionnaire_response_email_outro_text' => '<p>Merci pour votre temps et votre engagement civique.<br></p>',
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
