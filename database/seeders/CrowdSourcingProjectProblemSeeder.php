<?php

namespace Database\Seeders;

use App\BusinessLogicLayer\lkp\CrowdSourcingProjectProblemStatusLkp;
use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblem;
use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemTranslation;
use Illuminate\Database\Seeder;

class CrowdSourcingProjectProblemSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $problems = [
            [
                'id' => 1,
                'project_id' => 1,
                'slug' => 'european-elections-problem-1',
                'status_id' => CrowdSourcingProjectProblemStatusLkp::PUBLISHED,
                'img_url' => 'https://placehold.co/600x400',
                'default_language_id' => 6,
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'EU Elections Problem 1',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem ratione vitae, eum numquam autem optio amet pariatur ab quisquam sit ad dolor eius magnam repellat sunt perferendis ipsum expedita. Maxime?',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Εκλογές EU Πρόβλημα 1',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem ratione vitae, eum numquam autem optio amet pariatur ab quisquam sit ad dolor eius magnam repellat sunt perferendis ipsum expedita. Maxime?',
                    ],
                ],
            ],
            [
                'id' => 2,
                'project_id' => 1,
                'slug' => 'european-elections-problem-2',
                'status_id' => CrowdSourcingProjectProblemStatusLkp::UNPUBLISHED,
                'img_url' => 'https://placehold.co/600x400',
                'default_language_id' => 6,
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'EU Elections Problem 2',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem ratione vitae, eum numquam autem optio amet pariatur ab quisquam sit ad dolor eius magnam repellat sunt perferendis ipsum expedita. Maxime?',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Εκλογές EU Πρόβλημα 2',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem ratione vitae, eum numquam autem optio amet pariatur ab quisquam sit ad dolor eius magnam repellat sunt perferendis ipsum expedita. Maxime?',
                    ],
                ],
            ],
            [
                'id' => 3,
                'project_id' => 1,
                'slug' => 'european-elections-problem-3',
                'status_id' => CrowdSourcingProjectProblemStatusLkp::PUBLISHED,
                'img_url' => 'https://placehold.co/600x400',
                'default_language_id' => 12,
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'EU Elections Problem 3',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem ratione vitae, eum numquam autem optio amet pariatur ab quisquam sit ad dolor eius magnam repellat sunt perferendis ipsum expedita. Maxime?',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Εκλογές EU Πρόβλημα 3',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem ratione vitae, eum numquam autem optio amet pariatur ab quisquam sit ad dolor eius magnam repellat sunt perferendis ipsum expedita. Maxime?',
                    ],
                ],
            ],
            [
                'id' => 4,
                'project_id' => 2,
                'slug' => 'european-democracy-problem-1',
                'status_id' => CrowdSourcingProjectProblemStatusLkp::PUBLISHED,
                'img_url' => 'https://placehold.co/600x400',
                'default_language_id' => 12,
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'EU Democracy Problem 1',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem ratione vitae, eum numquam autem optio amet pariatur ab quisquam sit ad dolor eius magnam repellat sunt perferendis ipsum expedita. Maxime?',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Δημοκρατία EU Πρόβλημα 1',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem ratione vitae, eum numquam autem optio amet pariatur ab quisquam sit ad dolor eius magnam repellat sunt perferendis ipsum expedita. Maxime?',
                    ],
                ],
            ],
            [
                'id' => 5,
                'project_id' => 2,
                'slug' => 'european-democracy-problem-2',
                'status_id' => CrowdSourcingProjectProblemStatusLkp::UNPUBLISHED,
                'img_url' => 'https://placehold.co/600x400',
                'default_language_id' => 6,
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'EU Democracy Problem 2',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem ratione vitae, eum numquam autem optio amet pariatur ab quisquam sit ad dolor eius magnam repellat sunt perferendis ipsum expedita. Maxime?',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Δημοκρατία EU Πρόβλημα 2',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem ratione vitae, eum numquam autem optio amet pariatur ab quisquam sit ad dolor eius magnam repellat sunt perferendis ipsum expedita. Maxime?',
                    ],
                ],
            ],
            [
                'id' => 6,
                'project_id' => 4,
                'slug' => 'air-quality-europe-problem-1',
                'status_id' => CrowdSourcingProjectProblemStatusLkp::PUBLISHED,
                'img_url' => '/images/projects/air-quality-europe/problem-1.png',
                'default_language_id' => 6,
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
            ],
            [
                'id' => 7,
                'project_id' => 4,
                'slug' => 'air-quality-europe-problem-2',
                'status_id' => CrowdSourcingProjectProblemStatusLkp::PUBLISHED,
                'img_url' => '/images/projects/air-quality-europe/problem-2.png',
                'default_language_id' => 12,
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
            ],
            [
                'id' => 8,
                'project_id' => 4,
                'slug' => 'air-quality-europe-problem-3',
                'status_id' => CrowdSourcingProjectProblemStatusLkp::PUBLISHED,
                'img_url' => null,
                'default_language_id' => 12,
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
                'id' => 9,
                'project_id' => 4,
                'slug' => 'air-quality-europe-problem-4',
                'status_id' => CrowdSourcingProjectProblemStatusLkp::PUBLISHED,
                'img_url' => '/images/projects/air-quality-europe/problem-4.png',
                'default_language_id' => 6,
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
            CrowdSourcingProjectProblem::updateOrCreate(['id' => $problem['id']], [
                'id' => $problem['id'],
                'project_id' => $problem['project_id'],
                'slug' => $problem['slug'],
                'status_id' => $problem['status_id'],
                'img_url' => $problem['img_url'],
                'default_language_id' => $problem['default_language_id'],
            ]);
            if (isset($problem['translations'])) {
                foreach ($problem['translations'] as $translation) {
                    CrowdSourcingProjectProblemTranslation::updateOrCreate(
                        [
                            'problem_id' => $problem['id'],
                            'language_id' => $translation['language_id'],
                        ],
                        [
                            'problem_id' => $problem['id'],
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
