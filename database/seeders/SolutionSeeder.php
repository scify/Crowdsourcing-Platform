<?php

namespace Database\Seeders;

use App\BusinessLogicLayer\lkp\SolutionStatusLkp;
use App\Models\Solution\Solution;
use App\Models\Solution\SolutionTranslation;
use Illuminate\Database\Seeder;

class SolutionSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $solutions = [
            // Problem 1 — City Centre Parking Shortage (project 2)
            [
                'id' => 1,
                'problem_id' => 1,
                'user_creator_id' => 3,
                'slug' => 'park-and-ride-scheme',
                'status_id' => SolutionStatusLkp::PUBLISHED,
                'img_url' => '/images/solutions/solution-1.webp',
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'Expand Park-and-Ride Scheme',
                        'description' => 'Develop dedicated park-and-ride hubs at major city entry points with frequent, free shuttle buses to the centre. This removes cars before they enter congested areas and offers a convenient, sustainable alternative to city centre parking.',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Επέκταση Συστήματος Park-and-Ride',
                        'description' => 'Ανάπτυξη αφιερωμένων σταθμών park-and-ride στα κύρια σημεία εισόδου της πόλης με συχνά, δωρεάν λεωφορεία ανακύκλωσης προς το κέντρο. Αυτό απομακρύνει τα αυτοκίνητα πριν εισέλθουν στις συμφορημένες περιοχές.',
                    ],
                ],
            ],
            [
                'id' => 2,
                'problem_id' => 1,
                'user_creator_id' => 4,
                'slug' => 'dynamic-parking-pricing',
                'status_id' => SolutionStatusLkp::PUBLISHED,
                'img_url' => '/images/solutions/solution-2.webp',
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'Introduce Dynamic Parking Pricing',
                        'description' => 'Use real-time sensors and variable pricing to distribute demand evenly across all available parking facilities. Prices rise in busy areas and fall in underused ones, guiding drivers to available spaces and reducing search traffic by an estimated 30%.',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Εισαγωγή Δυναμικής Τιμολόγησης Στάθμευσης',
                        'description' => 'Χρήση αισθητήρων πραγματικού χρόνου και μεταβλητής τιμολόγησης για ομοιόμορφη κατανομή της ζήτησης σε όλες τις διαθέσιμες θέσεις. Οι τιμές αυξάνονται στις πολυσύχναστες περιοχές και μειώνονται στις λιγότερο χρησιμοποιούμενες.',
                    ],
                ],
            ],
            // Problem 2 — Inadequate Cycling Infrastructure (project 2)
            [
                'id' => 3,
                'problem_id' => 2,
                'user_creator_id' => 5,
                'slug' => 'protected-cycle-lanes',
                'status_id' => SolutionStatusLkp::PUBLISHED,
                'img_url' => '/images/solutions/solution-3.webp',
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'Build Protected Cycle Lanes on Main Roads',
                        'description' => 'Physically separated bike lanes on the 10 busiest corridors would enable safe cycling for all ages and abilities. Kerb-protected lanes, dedicated traffic signals, and secure parking at key destinations would make cycling a viable option for daily commuters.',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Κατασκευή Προστατευμένων Ποδηλατοδρόμων στους Κύριους Δρόμους',
                        'description' => 'Φυσικά διαχωρισμένες ποδηλατικές λωρίδες στους 10 πιο πολυσύχναστους δρόμους θα επέτρεπαν ασφαλή ποδηλασία για όλες τις ηλικίες. Φραγές, αφιερωμένα φανάρια και ασφαλής στάθμευση στους κύριους προορισμούς.',
                    ],
                ],
            ],
            [
                'id' => 4,
                'problem_id' => 2,
                'user_creator_id' => 3,
                'slug' => 'city-bike-sharing-program',
                'status_id' => SolutionStatusLkp::PUBLISHED,
                'img_url' => '/images/solutions/solution-4.webp',
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'Launch City-Wide Bike Sharing Program',
                        'description' => 'A network of 500+ docking stations with e-bikes would make cycling accessible to all commuters regardless of physical fitness. Pay-per-minute pricing and a monthly subscription option would serve both occasional and regular riders.',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Εκκίνηση Προγράμματος Κοινόχρηστων Ποδηλάτων σε Επίπεδο Πόλης',
                        'description' => 'Ένα δίκτυο 500+ σταθμών σύνδεσης με e-bikes θα καθιστούσε την ποδηλασία προσβάσιμη σε όλους τους μετακινούμενους ανεξαρτήτως φυσικής κατάστασης.',
                    ],
                ],
            ],
            // Problem 3 — Urban Heat Islands (project 2)
            [
                'id' => 5,
                'problem_id' => 3,
                'user_creator_id' => 4,
                'slug' => 'urban-greening-corridors',
                'status_id' => SolutionStatusLkp::PUBLISHED,
                'img_url' => '/images/solutions/solution-5.webp',
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'Create Urban Greening Corridors',
                        'description' => 'Plant trees every 8 metres along main streets and install water-absorbing permeable pavements to reduce surface temperatures by up to 4°C. Green corridors also improve air quality, reduce storm water runoff, and provide shade for pedestrians.',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Δημιουργία Πράσινων Αστικών Διαδρόμων',
                        'description' => 'Φύτευση δέντρων κάθε 8 μέτρα κατά μήκος των κύριων δρόμων και εγκατάσταση υδατοαπορροφητικών πεζοδρομίων για μείωση της θερμοκρασίας επιφάνειας κατά έως 4°C. Οι πράσινοι διάδρομοι βελτιώνουν επίσης την ποιότητα του αέρα.',
                    ],
                ],
            ],
            // Problem 4 — Low Voter Engagement (project 3)
            [
                'id' => 6,
                'problem_id' => 4,
                'user_creator_id' => 3,
                'slug' => 'digital-voter-registration',
                'status_id' => SolutionStatusLkp::PUBLISHED,
                'img_url' => '/images/solutions/solution-6.webp',
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'Streamlined Digital Voter Registration',
                        'description' => 'A one-click online registration system linked to the national ID database would remove the biggest bureaucratic barrier to enrolment. Automatic reminders ahead of elections and mobile-friendly access would significantly increase registration rates among young voters.',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Απλοποιημένη Ψηφιακή Εγγραφή Ψηφοφόρων',
                        'description' => 'Ένα σύστημα ηλεκτρονικής εγγραφής ενός κλικ συνδεδεμένο με το εθνικό μητρώο θα εξάλειφε το μεγαλύτερο γραφειοκρατικό εμπόδιο. Αυτόματες υπενθυμίσεις πριν από εκλογές και πρόσβαση μέσω κινητού.',
                    ],
                ],
            ],
            [
                'id' => 7,
                'problem_id' => 4,
                'user_creator_id' => 5,
                'slug' => 'civic-education-schools',
                'status_id' => SolutionStatusLkp::PUBLISHED,
                'img_url' => '/images/solutions/solution-7.webp',
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'Civic Education Programme in Schools',
                        'description' => 'Mandatory civic participation modules from age 14 would foster a culture of democratic engagement before voting age. Practical exercises — such as mock elections, local council visits, and community project planning — build lasting civic habits.',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Πρόγραμμα Πολιτικής Αγωγής στα Σχολεία',
                        'description' => 'Υποχρεωτικά μαθήματα συμμετοχής πολιτών από 14 ετών θα καλλιεργούσαν μια κουλτούρα δημοκρατικής εμπλοκής πριν από την ηλικία ψήφου. Πρακτικές ασκήσεις όπως εικονικές εκλογές και επισκέψεις σε τοπικά συμβούλια.',
                    ],
                ],
            ],
            // Problem 5 — Digital Exclusion of Elderly (project 3)
            [
                'id' => 8,
                'problem_id' => 5,
                'user_creator_id' => 4,
                'slug' => 'digital-literacy-hubs',
                'status_id' => SolutionStatusLkp::PUBLISHED,
                'img_url' => '/images/solutions/solution-8.webp',
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'Free Digital Literacy Hubs at Libraries',
                        'description' => 'Staffed digital assistance desks at all public libraries with simplified tablets and patient one-on-one guidance. Weekly drop-in sessions covering online government services, video calls, and safe browsing would bridge the digital divide for seniors.',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Δωρεάν Κέντρα Ψηφιακής Γραμματισμού στις Βιβλιοθήκες',
                        'description' => 'Εξοπλισμένα κέντρα ψηφιακής υποστήριξης σε όλες τις δημόσιες βιβλιοθήκες με απλοποιημένα tablet και υπομονετική ατομική καθοδήγηση. Εβδομαδιαίες συνεδρίες για ηλεκτρονικές δημόσιες υπηρεσίες και ασφαλή περιήγηση.',
                    ],
                ],
            ],
            // Problem 6 — Inefficient Waste Collection (project 4)
            [
                'id' => 9,
                'problem_id' => 6,
                'user_creator_id' => 1,
                'slug' => 'iot-waste-sensors',
                'status_id' => SolutionStatusLkp::PUBLISHED,
                'img_url' => '/images/solutions/solution-9.webp',
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'IoT Fill-Level Sensors in Bins',
                        'description' => 'Smart sensors installed in bins transmit real-time fill-level data to a central platform. Collection trucks are dispatched only when bins reach 80% capacity, optimising routes dynamically and reducing collection costs and emissions by an estimated 30%.',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Αισθητήρες IoT Στάθμης Πλήρωσης σε Κάδους',
                        'description' => 'Έξυπνοι αισθητήρες εγκατεστημένοι στους κάδους μεταδίδουν δεδομένα στάθμης σε πραγματικό χρόνο. Τα φορτηγά αποκομιδής αποστέλλονται μόνο όταν οι κάδοι φτάνουν το 80% της χωρητικότητας, βελτιστοποιώντας τις διαδρομές.',
                    ],
                ],
            ],
            [
                'id' => 10,
                'problem_id' => 6,
                'user_creator_id' => 2,
                'slug' => 'waste-data-dashboard',
                'status_id' => SolutionStatusLkp::UNPUBLISHED,
                'img_url' => '/images/solutions/solution-10.webp',
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'Public Waste Data Dashboard',
                        'description' => 'A live public dashboard showing collection efficiency, recycling rates, and cost savings would increase citizen trust and participation. Transparency about waste management performance encourages residents to recycle correctly and report issues promptly.',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Δημόσιος Πίνακας Δεδομένων Αποβλήτων',
                        'description' => 'Ένας ζωντανός δημόσιος πίνακας που εμφανίζει αποδοτικότητα αποκομιδής, ποσοστά ανακύκλωσης και εξοικονόμηση κόστους θα αυξήσει την εμπιστοσύνη και τη συμμετοχή των πολιτών.',
                    ],
                ],
            ],
            // Problem 7 — Static Street Lighting (project 4)
            [
                'id' => 11,
                'problem_id' => 7,
                'user_creator_id' => 1,
                'slug' => 'adaptive-led-lighting',
                'status_id' => SolutionStatusLkp::PUBLISHED,
                'img_url' => '/images/solutions/solution-11.webp',
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'Adaptive LED Lighting with Motion Sensors',
                        'description' => 'LED streetlights fitted with motion sensors dim to 20% output during low-activity periods and brighten to full power within 0.5 seconds of detecting movement. This adaptive approach can cut street lighting energy consumption by up to 60% while maintaining safety standards.',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Προσαρμοστικός Φωτισμός LED με Αισθητήρες Κίνησης',
                        'description' => 'Φωτιστικά LED εξοπλισμένα με αισθητήρες κίνησης μειώνουν την ισχύ στο 20% κατά τις ώρες χαμηλής δραστηριότητας και φωτίζουν πλήρως σε 0,5 δευτερόλεπτα από την ανίχνευση κίνησης. Μπορεί να μειώσει την κατανάλωση ενέργειας φωτισμού κατά 60%.',
                    ],
                ],
            ],
        ];

        foreach ($solutions as $solution) {
            Solution::withTrashed()->updateOrCreate(['id' => $solution['id']], [
                'id' => $solution['id'],
                'problem_id' => $solution['problem_id'],
                'user_creator_id' => $solution['user_creator_id'],
                'slug' => $solution['slug'],
                'status_id' => $solution['status_id'],
                'img_url' => $solution['img_url'],
            ]);
            if (isset($solution['translations'])) {
                foreach ($solution['translations'] as $translation) {
                    SolutionTranslation::updateOrCreate(
                        [
                            'solution_id' => $solution['id'],
                            'language_id' => $translation['language_id'],
                        ],
                        [
                            'solution_id' => $solution['id'],
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
