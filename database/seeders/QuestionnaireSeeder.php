<?php

namespace Database\Seeders;

use App\BusinessLogicLayer\lkp\QuestionnaireStatusLkp;
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

    public function run(): void {
        $questionnaires = [
            // Q1 — Climate Action Survey (project 1) — PUBLISHED
            // Questions: rating + checkbox + comment
            [
                'id' => 1,
                'project_id' => 1,
                'type_id' => QuestionnaireTypeLkp::MAIN_QUESTIONNAIRE,
                'status_id' => QuestionnaireStatusLkp::PUBLISHED,
                'default_language_id' => 6,
                'goal' => 150,
                'max_votes_num' => 10,
                'statistics_page_visibility_lkp_id' => 1,
                'show_general_statistics' => 1,
                'show_file_type_questions_to_statistics_page_audience' => 1,
                'respondent_auth_required' => 0,
                'questionnaire_json' => '{"title":{"default":"Climate Action Priorities Survey","gr":"Έρευνα Προτεραιοτήτων Κλιματικής Δράσης"},"description":{"default":"Help us understand which climate measures matter most to you.","gr":"Βοηθήστε μας να κατανοήσουμε ποια κλιματικά μέτρα σας ενδιαφέρουν περισσότερο."},"logoPosition":"right","pages":[{"name":"page1","elements":[{"type":"rating","name":"q1_urgency","title":{"default":"How urgent is climate action in your city?","gr":"Πόσο επείγουσα είναι η κλιματική δράση στην πόλη σας;"},"rateMin":1,"rateMax":5,"minRateDescription":{"default":"Not urgent at all","gr":"Καθόλου επείγον"},"maxRateDescription":{"default":"Extremely urgent","gr":"Εξαιρετικά επείγον"}},{"type":"checkbox","name":"q2_priorities","title":{"default":"Which climate actions should be prioritised? (select all that apply)","gr":"Ποιες κλιματικές δράσεις πρέπει να προτεραιοποιηθούν;"},"choices":[{"value":"renewables","text":{"default":"Expand renewable energy","gr":"Επέκταση ανανεώσιμων πηγών ενέργειας"}},{"value":"transport","text":{"default":"Improve public transport & cycling","gr":"Βελτίωση δημόσιων μεταφορών & ποδηλασίας"}},{"value":"buildings","text":{"default":"Green building standards","gr":"Πράσινα πρότυπα κτιρίων"}},{"value":"greenspaces","text":{"default":"Expand urban green spaces","gr":"Επέκταση αστικών πράσινων χώρων"}},{"value":"waste","text":{"default":"Reduce waste & improve recycling","gr":"Μείωση αποβλήτων & βελτίωση ανακύκλωσης"}}]},{"type":"comment","name":"q3_suggestion","title":{"default":"What specific climate initiative would you most like to see implemented?","gr":"Ποια συγκεκριμένη κλιματική πρωτοβουλία θα θέλατε να δείτε να υλοποιείται;"}}]}]}',
            ],
            // Q2 — Digital Democracy (project 3) — PUBLISHED
            // Questions: radiogroup + checkbox + comment
            [
                'id' => 2,
                'project_id' => 3,
                'type_id' => QuestionnaireTypeLkp::MAIN_QUESTIONNAIRE,
                'status_id' => QuestionnaireStatusLkp::PUBLISHED,
                'default_language_id' => 6,
                'goal' => 100,
                'max_votes_num' => 5,
                'statistics_page_visibility_lkp_id' => 1,
                'show_general_statistics' => 1,
                'show_file_type_questions_to_statistics_page_audience' => 1,
                'respondent_auth_required' => 0,
                'questionnaire_json' => '{"title":{"default":"Digital Democracy & Civic Participation Survey","gr":"Έρευνα Ψηφιακής Δημοκρατίας & Συμμετοχής Πολιτών"},"description":{"default":"Tell us how you want to engage in local governance.","gr":"Πείτε μας πώς θέλετε να συμμετέχετε στη τοπική διακυβέρνηση."},"logoPosition":"right","pages":[{"name":"page1","elements":[{"type":"radiogroup","name":"q1_current_participation","title":{"default":"How do you currently participate in local governance?","gr":"Πώς συμμετέχετε αυτήν τη στιγμή στην τοπική διακυβέρνηση;"},"choices":[{"value":"vote_only","text":{"default":"I only vote in elections","gr":"Μόνο ψηφίζω στις εκλογές"}},{"value":"attend_meetings","text":{"default":"I attend community meetings","gr":"Παρακολουθώ κοινοτικές συναντήσεις"}},{"value":"online_petitions","text":{"default":"I sign online petitions / use digital platforms","gr":"Υπογράφω ηλεκτρονικές αναφορές / χρησιμοποιώ ψηφιακές πλατφόρμες"}},{"value":"not_at_all","text":{"default":"I do not participate","gr":"Δεν συμμετέχω"}}]},{"type":"checkbox","name":"q2_digital_tools","title":{"default":"Which digital tools would increase your civic participation?","gr":"Ποια ψηφιακά εργαλεία θα αύξαναν τη συμμετοχή σας στα κοινά;"},"choices":[{"value":"mobile_app","text":{"default":"Mobile app for reporting issues","gr":"Εφαρμογή κινητού για αναφορά προβλημάτων"}},{"value":"online_voting","text":{"default":"Secure online voting","gr":"Ασφαλής ηλεκτρονική ψηφοφορία"}},{"value":"open_data","text":{"default":"Open data dashboards","gr":"Παρουσιάσεις ανοικτών δεδομένων"}},{"value":"forums","text":{"default":"Moderated digital forums","gr":"Συντονισμένα ψηφιακά φόρουμ"}}]},{"type":"comment","name":"q3_barrier","title":{"default":"What is the biggest barrier preventing you from participating more in civic life?","gr":"Ποιο είναι το μεγαλύτερο εμπόδιο που σας αποτρέπει από το να συμμετέχετε περισσότερο;"}}]}]}',
            ],
            // Q3 — Smart Cities 2030 (project 4) — FINALIZED
            // Questions: radiogroup + rating + comment
            [
                'id' => 3,
                'project_id' => 4,
                'type_id' => QuestionnaireTypeLkp::MAIN_QUESTIONNAIRE,
                'status_id' => QuestionnaireStatusLkp::FINALIZED,
                'default_language_id' => 6,
                'goal' => 200,
                'max_votes_num' => 10,
                'statistics_page_visibility_lkp_id' => 1,
                'show_general_statistics' => 1,
                'show_file_type_questions_to_statistics_page_audience' => 1,
                'respondent_auth_required' => 0,
                'questionnaire_json' => '{"title":{"default":"Smart Cities 2030 — Community Vision Survey","gr":"Έξυπνες Πόλεις 2030 — Έρευνα Κοινοτικού Οράματος"},"description":{"default":"This survey has concluded. Thank you to all 187 participants.","gr":"Αυτή η έρευνα έχει ολοκληρωθεί. Ευχαριστούμε όλους τους 187 συμμετέχοντες."},"logoPosition":"right","pages":[{"name":"page1","elements":[{"type":"radiogroup","name":"q1_smart_priority","title":{"default":"Which smart city feature is most important to you?","gr":"Ποιο χαρακτηριστικό έξυπνης πόλης είναι πιο σημαντικό για εσάς;"},"choices":[{"value":"smart_transport","text":{"default":"Smart & connected transport","gr":"Έξυπνες & διασυνδεδεμένες μεταφορές"}},{"value":"smart_energy","text":{"default":"Smart energy grids","gr":"Έξυπνα ενεργειακά δίκτυα"}},{"value":"smart_safety","text":{"default":"Enhanced public safety systems","gr":"Βελτιωμένα συστήματα δημόσιας ασφάλειας"}},{"value":"smart_services","text":{"default":"Digital public services","gr":"Ψηφιακές δημόσιες υπηρεσίες"}}]},{"type":"rating","name":"q2_readiness","title":{"default":"How ready do you feel your city is to become a smart city?","gr":"Πόσο έτοιμη νιώθετε ότι είναι η πόλη σας για να γίνει έξυπνη πόλη;"},"rateMin":1,"rateMax":5,"minRateDescription":{"default":"Not ready","gr":"Καθόλου έτοιμη"},"maxRateDescription":{"default":"Fully ready","gr":"Πλήρως έτοιμη"}},{"type":"comment","name":"q3_concern","title":{"default":"What is your biggest concern about smart city technology?","gr":"Ποια είναι η μεγαλύτερη ανησυχία σας σχετικά με την τεχνολογία έξυπνης πόλης;"}}]}]}',
            ],
        ];

        $questionnaire_fields_translations = [
            ['questionnaire_id' => 1, 'language_id' => 6, 'title' => 'Climate Action Priorities Survey', 'description' => 'Help us understand which climate measures matter most to you.'],
            ['questionnaire_id' => 1, 'language_id' => 12, 'title' => 'Έρευνα Προτεραιοτήτων Κλιματικής Δράσης', 'description' => 'Βοηθήστε μας να κατανοήσουμε ποια κλιματικά μέτρα σας ενδιαφέρουν περισσότερο.'],
            ['questionnaire_id' => 2, 'language_id' => 6, 'title' => 'Digital Democracy & Civic Participation Survey', 'description' => 'Tell us how you want to engage in local governance.'],
            ['questionnaire_id' => 2, 'language_id' => 12, 'title' => 'Έρευνα Ψηφιακής Δημοκρατίας & Συμμετοχής Πολιτών', 'description' => 'Πείτε μας πώς θέλετε να συμμετέχετε στη τοπική διακυβέρνηση.'],
            ['questionnaire_id' => 3, 'language_id' => 6, 'title' => 'Smart Cities 2030 — Community Vision Survey', 'description' => 'This survey has concluded. Thank you to all 187 participants.'],
            ['questionnaire_id' => 3, 'language_id' => 12, 'title' => 'Έξυπνες Πόλεις 2030 — Έρευνα Κοινοτικού Οράματος', 'description' => 'Αυτή η έρευνα έχει ολοκληρωθεί. Ευχαριστούμε όλους τους 187 συμμετέχοντες.'],
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
