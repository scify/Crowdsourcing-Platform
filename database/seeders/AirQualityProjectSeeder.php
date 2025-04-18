<?php

namespace Database\Seeders;

use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\BusinessLogicLayer\lkp\ProblemStatusLkp;
use App\BusinessLogicLayer\lkp\SolutionStatusLkp;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\CrowdSourcingProject\CrowdSourcingProjectTranslation;
use App\Models\Problem\Problem;
use App\Models\Problem\ProblemTranslation;
use App\Models\Solution\Solution;
use App\Models\Solution\SolutionTranslation;
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
            'external_url' => 'https://ecas.org/projects/indeu/',
            'img_path' => '/images/projects/air-quality-europe/logo-bg.webp',
            'logo_path' => '/images/projects/air-quality-europe/logo.webp',
            'user_creator_id' => 1,
            'language_id' => 6,
            'should_send_email_after_questionnaire_response' => 1,
            'lp_primary_color' => '#f5ba16',
            'lp_btn_text_color_theme' => 'dark',
            'lp_questionnaire_image_path' => '/images/projects/air-quality-europe/logo.webp',
            'lp_show_speak_up_btn' => 1,
            'sm_featured_img_path' => '/images/projects/air-quality-europe/logo.webp',
            'display_landing_page_banner' => 0,
            'status_id' => CrowdSourcingProjectStatusLkp::PUBLISHED,
        ];

        $project_translations = [
            [
                'language_id' => 6,
                'project_id' => 4,
                'name' => 'Air Quality in Europe',
                'motto_title' => 'Please share with us your opinion on the air quality in Europe. Your voice matters!',
                'motto_subtitle' => 'You can make an impact! Share your opinion with us!',
                'description' => 'Lorem ipsum dolor site amet',
                'about' => '<h2>About the Project</h2><p>Contribute to solving air quality problems in Athens and across Europe. Write points for and against the proposed solutions. Your contributions will be a valuable contribution to official policy to improve air quality in Athens and across Europe.</p><p>Nunc at nisl eget ante sollicitudin elementum at quis magna. Nullam semper scelerisque lacus ut condimentum. Sed non finibus lacus. Fusce nec ornare turpis. Praesent ut sem sed metus semper auctor. Aenean in dui nec libero tempus convallis. Aenean rutrum felis laoreet dolor semper, commodo laoreet risus ultrices. Maecenas non urna hendrerit, faucibus arcu sed, commodo nulla. Phasellus eu tempor dui, ut sodales eros. Aliquam velit libero, malesuada eget laoreet ut, lobortis non sapien. Cras ex nulla, blandit nec luctus non, euismod at ipsum. Maecenas venenatis congue massa. Sed a odio quis mi scelerisque ornare eu sed libero. Sed malesuada diam nisl, ut maximus ligula tristique et. Sed vestibulum id felis ut blandit. Mauris mollis lectus lorem, vulputate tempor est egestas vel.</p><h2>Why you can help us</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas pulvinar mi quis erat commodo rhoncus. Etiam at sapien leo. Vivamus non placerat mi, placerat consectetur ante. Pellentesque egestas mi sit amet leo feugiat bibendum. Donec ut placerat mauris. Donec dapibus varius venenatis. Cras congue est in gravida lobortis.</p><p>Nunc at nisl eget ante sollicitudin elementum at quis magna. Nullam semper scelerisque lacus ut condimentum. Sed non finibus lacus. Fusce nec ornare turpis. Praesent ut sem sed metus semper auctor. Aenean in dui nec libero tempus convallis. Aenean rutrum felis laoreet dolor semper, commodo laoreet risus ultrices. Maecenas non urna hendrerit, faucibus arcu sed, commodo nulla. Phasellus eu tempor dui, ut sodales eros. Aliquam velit libero, malesuada eget laoreet ut, lobortis non sapien. Cras ex nulla, blandit nec luctus non, euismod at ipsum. Maecenas venenatis congue massa. Sed a odio quis mi scelerisque ornare eu sed libero. Sed malesuada diam nisl, ut maximus ligula tristique et. Sed vestibulum id felis ut blandit. Mauris mollis lectus lorem, vulputate tempor est egestas vel.</p><h2>What is crowdsourcing?</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas pulvinar mi quis erat commodo rhoncus. Etiam at sapien leo. Vivamus non placerat mi, placerat consectetur ante. Pellentesque egestas mi sit amet leo feugiat bibendum. Donec ut placerat mauris. Donec dapibus varius venenatis. Cras congue est in gravida lobortis.</p><p>Nunc at nisl eget ante sollicitudin elementum at quis magna. Nullam semper scelerisque lacus ut condimentum. Sed non finibus lacus. Fusce nec ornare turpis. Praesent ut sem sed metus semper auctor. Aenean in dui nec libero tempus convallis. Aenean rutrum felis laoreet dolor semper, commodo laoreet risus ultrices. Maecenas non urna hendrerit, faucibus arcu sed, commodo nulla. Phasellus eu tempor dui, ut sodales eros. Aliquam velit libero, malesuada eget laoreet ut, lobortis non sapien. Cras ex nulla, blandit nec luctus non, euismod at ipsum. Maecenas venenatis congue massa. Sed a odio quis mi scelerisque ornare eu sed libero. Sed malesuada diam nisl, ut maximus ligula tristique et. Sed vestibulum id felis ut blandit. Mauris mollis lectus lorem, vulputate tempor est egestas vel.</p>',
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
            $this->projectTranslationRepository->updateOrCreate(['project_id' => $project_translation['project_id'], 'language_id' => $project_translation['language_id']],
                Helpers::getFilteredAttributes($project_translation, (new CrowdSourcingProjectTranslation)->getFillable()));
            if (app()->environment() !== 'testing') {
                echo "\nAdded Project Translation: " . $project_translation['name'] . ' with lang id: ' . $project_translation['language_id'] . "\n";
            }
        }

        // call the CrowdSourcingProjectProblemStatusLkpSeeder
        $this->call(ProblemStatusLkpSeeder::class);
        $this->call(SolutionStatusLkpSeeder::class);

        $problems = [
            [
                'id' => 7,
                'project_id' => 4,
                'slug' => 'aqe-problem-1',
                'status_id' => ProblemStatusLkp::PUBLISHED,
                'img_url' => '/images/projects/air-quality-europe/problem-1.png',
                'default_language_id' => 6,
                'user_creator_id' => 1,
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'Health Issues',
                        'description' => 'Cancer, mental health problems, asthma, headaches: the list of health problems from air pollution is long! How can we ensure that citizens stay healthy?',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Προβλήματα Υγείας',
                        'description' => 'Καρκίνος, ψυχικές διαταραχές, άσθμα, πονοκέφαλοι: ο κατάλογος των προβλημάτων υγείας από την ατμοσφαιρική ρύπανση είναι μακρύς! Πώς μπορούμε να διασφαλίσουμε ότι οι πολίτες θα παραμείνουν υγιείς;',
                    ],
                ],
                'solutions' => [
                    [
                        'id' => 5,
                        'user_creator_id' => 1,
                        'slug' => 'aqe-pblm1-solution-1',
                        'status_id' => SolutionStatusLkp::PUBLISHED,
                        'img_url' => 'https://placehold.co/615x415',
                        'translations' => [
                            [
                                'language_id' => 6,
                                'title' => 'Make emission regulations stricter',
                                'description' => 'Enforcing strict emission regulations can significantly reduce air pollution, thus protecting public health by ensuring cleaner, breathable air for all communities.',
                            ],
                            [
                                'language_id' => 12,
                                'title' => 'Εφαρμογή αυστηρότερων κανονισμών για εκπομπές ρύπων',
                                'description' => 'Η επιβολή αυστηρών κανονισμών εκπομπών μπορεί να μειώσει σημαντικά τη ρύπανση του αέρα, προστατεύοντας έτσι τη δημόσια υγεία με τη διασφάλιση καθαρού, αναπνεύσιμου αέρα για όλες τις κοινότητες.',
                            ],
                        ],
                    ],
                    [
                        'id' => 6,
                        'user_creator_id' => 1,
                        'slug' => 'aqe-pblm1-solution-2',
                        'status_id' => SolutionStatusLkp::PUBLISHED,
                        'img_url' => 'https://placehold.co/615x415',
                        'translations' => [
                            [
                                'language_id' => 6,
                                'title' => 'Improving Public Transportation',
                                'description' => 'Encouraging the use of public transportation, cycling, and walking can reduce the number of cars on the road, decreasing air pollution and improving public health. Investing in public transportation infrastructure and creating pedestrian-friendly urban spaces can help reduce emissions and improve air quality in cities.',
                            ],
                            [
                                'language_id' => 12,
                                'title' => 'Βελτίωση των Δημόσιων Μεταφορών',
                                'description' => 'Η ενθάρρυνση της χρήσης των δημόσιων μέσων μεταφοράς, η ποδηλασία και το περπάτημα μπορεί να μειώσει τον αριθμό των αυτοκινήτων στο δρόμο, να μειώσει την ατμοσφαιρική ρύπανση και να βελτιώσει τη δημόσια υγεία. Η επένδυση σε υποδομές δημόσιων μεταφορών και η δημιουργία αστικών χώρων φιλικών για τους πεζούς μπορεί να συμβάλει στη μείωση των εκπομπών και στη βελτίωση της ποιότητας του αέρα στις πόλεις.',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'id' => 8,
                'project_id' => 4,
                'slug' => 'aqe-problem-2',
                'status_id' => ProblemStatusLkp::PUBLISHED,
                'img_url' => '/images/projects/air-quality-europe/problem-2.png',
                'default_language_id' => 12,
                'user_creator_id' => 1,
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'Proper Air Pollution Management',
                        'description' => 'Poorly designed urban management (lack of local consultation before creating projects, identifying solutions) and poor access to information about air pollution sources, health risks, and mitigation strategies can lead to ineffective policies that fail to address the root causes of pollution, exacerbating environmental and public health issues in urban areas.',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Σωστή Διαχείριση της Ατμοσφαιρικής Ρύπανσης',
                        'description' => 'Η κακώς σχεδιασμένη διαχείριση των αστικών περιοχών (έλλειψη τοπικών διαβουλεύσεων πριν τη δημιουργία έργων, αναγνώριση λύσεων) και η ανεπαρκής πρόσβαση σε πληροφορίες σχετικά με τις πηγές ατμοσφαιρικής ρύπανσης, τους κινδύνους για την υγεία και τις στρατηγικές μετριασμού, μπορεί να οδηγήσουν σε αναποτελεσματικές πολιτικές που δεν αντιμετωπίζουν τα βασικά αίτια της ρύπανσης, επιδεινώνοντας τα περιβαλλοντικά και τα ζητήματα δημόσιας υγείας στις αστικές περιοχές.',
                    ],
                ],
                'solutions' => [
                    [
                        'id' => 7,
                        'user_creator_id' => 1,
                        'slug' => 'aqe-pblm2-solution-1',
                        'status_id' => SolutionStatusLkp::PUBLISHED,
                        'img_url' => 'https://placehold.co/615x415',
                        'translations' => [
                            [
                                'language_id' => 6,
                                'title' => 'Air Filtration Systems',
                                'description' => 'Advanced air filtration systems combat health issues by ensuring breathable, pollution-free environments for all.',
                            ],
                            [
                                'language_id' => 12,
                                'title' => 'Συστήματα Φιλτραρίσματος Αέρα',
                                'description' => 'Προηγμένα συστήματα διήθησης αέρα καταπολεμούν τα προβλήματα υγείας διασφαλίζοντας αναπνεύσιμα, χωρίς ρύπους περιβάλλοντα για όλους.',
                            ],
                        ],
                    ],
                    [
                        'id' => 8,
                        'user_creator_id' => 1,
                        'slug' => 'aqe-pblm2-solution-2',
                        'status_id' => SolutionStatusLkp::UNPUBLISHED,
                        'img_url' => 'https://placehold.co/615x415',
                        'translations' => [
                            [
                                'language_id' => 6,
                                'title' => 'Better Urban Planning',
                                'description' => 'Poorly designed urban spaces can lead to increased air pollution, traffic congestion, and public health issues. Creating green spaces, pedestrian zones, and bike lanes can help reduce emissions, improve air quality, and create healthier and more sustainable cities for all citizens.',
                            ],
                            [
                                'language_id' => 12,
                                'title' => 'Καλύτερος Αστικός Σχεδιασμός',
                                'description' => 'Οι κακοσχεδιασμένοι αστικοί χώροι μπορούν να οδηγήσουν σε αυξημένη ατμοσφαιρική ρύπανση, κυκλοφοριακή συμφόρηση και ζητήματα δημόσιας υγείας. Η δημιουργία χώρων πρασίνου, πεζόδρομων και ποδηλατοδρόμων μπορεί να συμβάλει στη μείωση των εκπομπών, στη βελτίωση της ποιότητας του αέρα και στη δημιουργία πιο υγιεινών και πιο βιώσιμων πόλεων για όλους τους πολίτες.',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'id' => 9,
                'project_id' => 4,
                'slug' => 'aqe-problem-3',
                'status_id' => ProblemStatusLkp::PUBLISHED,
                'img_url' => null,
                'default_language_id' => 12,
                'user_creator_id' => 1,
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'Forest Wildfires',
                        'description' => 'In recent years, increasing wildfires across southern and central Europe have significantly worsened air quality, releasing large amounts of pollutants like fine particulate matter (PM2.5) and carbon monoxide into the atmosphere. These fires, exacerbated by climate change and prolonged heatwaves, are affecting public health, agriculture, and ecosystems. Efforts to control emissions and improve early warning systems are critical in mitigating the growing environmental and health impacts across the continent.',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Δασικές Πυρκαγιές',
                        'description' => 'Τα τελευταία χρόνια, οι αυξανόμενες δασικές πυρκαγιές στη νότια και κεντρική Ευρώπη έχουν επιδεινώσει σημαντικά την ποιότητα του αέρα, απελευθερώνοντας μεγάλες ποσότητες ρύπων όπως τα αιωρούμενα σωματίδια (PM2.5) και το μονοξείδιο του άνθρακα στην ατμόσφαιρα. Αυτές οι πυρκαγιές, που επιδεινώνονται από την κλιματική αλλαγή και τους παρατεταμένους καύσωνες, επηρεάζουν τη δημόσια υγεία, τη γεωργία και τα οικοσυστήματα. Οι προσπάθειες ελέγχου των εκπομπών και η βελτίωση των συστημάτων έγκαιρης προειδοποίησης είναι κρίσιμες για την αντιμετώπιση των αυξανόμενων περιβαλλοντικών και υγειονομικών επιπτώσεων σε όλη την ήπειρο.',
                    ],
                ],
            ],
            [
                'id' => 10,
                'project_id' => 4,
                'slug' => 'aqe-problem-4',
                'status_id' => ProblemStatusLkp::PUBLISHED,
                'img_url' => '/images/projects/air-quality-europe/problem-4.png',
                'default_language_id' => 6,
                'user_creator_id' => 1,
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'Air Pollution due to Domestic Heating',
                        'description' => 'Are there coal and wood heating systems in your neighborhood? Direct exposure to their fumes or their penetration into your home can harm your health and the environment.',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Ατμοσφαιρική Ρύπανση από Θέρμανση Κατοικιών',
                        'description' => 'Υπάρχουν συστήματα θέρμανσης με ξύλο και άνθρακα στη γειτονιά σας; Η άμεση έκθεση στους καπνούς τους ή η διείσδυσή τους στο σπίτι σας μπορεί να βλάψει την υγεία σας και το περιβάλλον.',
                    ],
                ],
            ],
        ];

        foreach ($problems as $problem) {
            $problemRecord = Problem::withTrashed()->updateOrCreate(['id' => $problem['id']], [
                'project_id' => $problem['project_id'],
                'slug' => $problem['slug'],
                'status_id' => $problem['status_id'],
                'img_url' => $problem['img_url'],
                'default_language_id' => $problem['default_language_id'],
                'user_creator_id' => $problem['user_creator_id'],
            ]);
            if (isset($problem['translations'])) {
                foreach ($problem['translations'] as $translation) {
                    ProblemTranslation::updateOrCreate(
                        [
                            'problem_id' => $problemRecord->id,
                            'language_id' => $translation['language_id'],
                        ],
                        [
                            'problem_id' => $problemRecord->id,
                            'language_id' => $translation['language_id'],
                            'title' => $translation['title'],
                            'description' => $translation['description'],
                        ]
                    );
                }
            }

            if (isset($problem['solutions'])) {
                foreach ($problem['solutions'] as $solution) {
                    if (app()->environment() !== 'testing') {
                        echo "\nAdding Solution: " . $solution['slug'] . ' for Problem: ' . $problem['slug'] . "\n";
                    }
                    // if the solution already exists but is soft deleted, restore it. Search by slug
                    if ($existingSolution = Solution::withTrashed()->where('slug', $solution['slug'])->first()) {
                        $existingSolution->restore();
                    }
                    $solutionRecord = Solution::withTrashed()->updateOrCreate(['id' => $solution['id']], [
                        'id' => $solution['id'],
                        'problem_id' => $problemRecord->id,
                        'user_creator_id' => $solution['user_creator_id'],
                        'slug' => $solution['slug'],
                        'status_id' => $solution['status_id'],
                        'img_url' => $solution['img_url'],
                    ]);
                    if (isset($solution['translations'])) {
                        foreach ($solution['translations'] as $translation) {
                            if (app()->environment() !== 'testing') {
                                echo "\nAdding Solution Translation: " . $translation['title'] . ' for Solution: ' . $solution['slug'] . "\n";
                            }
                            SolutionTranslation::updateOrCreate(
                                [
                                    'solution_id' => $solutionRecord->id,
                                    'language_id' => $translation['language_id'],
                                ],
                                [
                                    'solution_id' => $solutionRecord->id,
                                    'language_id' => $translation['language_id'],
                                    'title' => $translation['title'],
                                    'description' => $translation['description'],
                                ]
                            );
                        }
                    }
                }
            }
        }

        if (app()->environment() !== 'testing') {
            echo "\nAdded Problems and Solutions for Project: " . $project['slug'] . "\n";
        }
    }
}
