<?php

namespace Database\Seeders;

use App\BusinessLogicLayer\lkp\ProblemStatusLkp;
use App\Models\Problem\Problem;
use App\Models\Problem\ProblemTranslation;
use Illuminate\Database\Seeder;

class ProblemSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $problems = [
            // Project 2 — Urban Innovation Hub — 3 published problems
            [
                'id' => 1,
                'project_id' => 2,
                'slug' => 'urban-parking-shortage',
                'status_id' => ProblemStatusLkp::PUBLISHED,
                'img_url' => '/images/problems/problem-1.webp',
                'default_language_id' => 6,
                'user_creator_id' => 3,
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'City Centre Parking Shortage',
                        'description' => 'The chronic shortage of city centre parking forces residents to drive further looking for spaces, increasing congestion, emissions, and frustration. Peripheral areas are overcrowded while central destinations remain inaccessible by car.',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Έλλειψη Θέσεων Στάθμευσης στο Κέντρο',
                        'description' => 'Η χρόνια έλλειψη θέσεων στάθμευσης στο κέντρο της πόλης αναγκάζει τους κατοίκους να οδηγούν περισσότερο αναζητώντας χώρο, αυξάνοντας την κυκλοφορία, τις εκπομπές και την απογοήτευση.',
                    ],
                    [
                        'language_id' => 11,
                        'title' => 'Parkplatzmangel in der Innenstadt',
                        'description' => 'Der chronische Mangel an Innenstadtparkplätzen zwingt Anwohner, länger nach Parkmöglichkeiten zu suchen, was Staus, Emissionen und Frustration erhöht. Periphere Bereiche sind überfüllt, während zentrale Ziele mit dem Auto unzugänglich bleiben.',
                    ],
                    [
                        'language_id' => 22,
                        'title' => 'Escasez de Aparcamiento en el Centro Urbano',
                        'description' => 'La crónica escasez de aparcamiento en el centro de la ciudad obliga a los residentes a conducir más en busca de plazas, aumentando la congestión, las emisiones y la frustración. Las zonas periféricas están saturadas mientras los destinos centrales permanecen inaccesibles en coche.',
                    ],
                    [
                        'language_id' => 10,
                        'title' => 'Manque de Stationnement en Centre-Ville',
                        'description' => 'La pénurie chronique de stationnement en centre-ville contraint les résidents à conduire plus loin pour trouver des places, augmentant la congestion, les émissions et la frustration. Les zones périphériques sont surpeuplées tandis que les destinations centrales restent inaccessibles en voiture.',
                    ],
                ],
            ],
            [
                'id' => 2,
                'project_id' => 2,
                'slug' => 'poor-cycling-infrastructure',
                'status_id' => ProblemStatusLkp::PUBLISHED,
                'img_url' => '/images/problems/problem-2.webp',
                'default_language_id' => 6,
                'user_creator_id' => 4,
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'Inadequate Cycling Infrastructure',
                        'description' => 'The lack of safe, connected cycling routes discourages residents from choosing sustainable transport. Gaps in the network force cyclists onto busy roads, making cycling feel dangerous and unattractive for all age groups.',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Ανεπαρκής Υποδομή Ποδηλασίας',
                        'description' => 'Η έλλειψη ασφαλών, διασυνδεδεμένων ποδηλατοδρόμων αποθαρρύνει τους κατοίκους από την επιλογή βιώσιμων μεταφορών. Τα κενά στο δίκτυο αναγκάζουν τους ποδηλάτες στους πολυσύχναστους δρόμους.',
                    ],
                    [
                        'language_id' => 11,
                        'title' => 'Unzureichende Fahrradinfrastruktur',
                        'description' => 'Das Fehlen sicherer, vernetzter Radwege schreckt die Bewohner davon ab, nachhaltige Verkehrsmittel zu wählen. Lücken im Netz zwingen Radfahrer auf belebte Straßen, was das Radfahren für alle Altersgruppen gefährlich und unattraktiv erscheinen lässt.',
                    ],
                    [
                        'language_id' => 22,
                        'title' => 'Infraestructura Ciclista Inadecuada',
                        'description' => 'La falta de rutas ciclistas seguras y conectadas desincentiva a los residentes de elegir el transporte sostenible. Las brechas en la red obligan a los ciclistas a circular por carreteras concurridas, haciendo que el ciclismo parezca peligroso y poco atractivo para todos los grupos de edad.',
                    ],
                    [
                        'language_id' => 10,
                        'title' => 'Infrastructure Cycliste Inadéquate',
                        'description' => 'Le manque d\'itinéraires cyclables sûrs et connectés dissuade les résidents de choisir des transports durables. Les lacunes du réseau forcent les cyclistes à emprunter des routes fréquentées, rendant le vélo dangereux et peu attrayant pour tous les groupes d\'âge.',
                    ],
                ],
            ],
            [
                'id' => 3,
                'project_id' => 2,
                'slug' => 'urban-heat-islands',
                'status_id' => ProblemStatusLkp::PUBLISHED,
                'img_url' => '/images/problems/problem-3.webp',
                'default_language_id' => 6,
                'user_creator_id' => 5,
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'Urban Heat Islands',
                        'description' => 'Concrete-heavy neighbourhoods suffer extreme heat in summer due to the lack of shade, green spaces, and permeable surfaces. Surface temperatures in these areas can exceed surrounding rural zones by 5–8°C, posing health risks for vulnerable residents.',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Αστικές Θερμικές Νησίδες',
                        'description' => 'Οι γειτονιές με πολύ σκυρόδεμα υποφέρουν από ακραία ζέστη το καλοκαίρι λόγω έλλειψης σκιάς, πράσινων χώρων και διαπερατών επιφανειών. Οι θερμοκρασίες επιφάνειας μπορεί να υπερβαίνουν τις αγροτικές περιοχές κατά 5–8°C.',
                    ],
                    [
                        'language_id' => 11,
                        'title' => 'Städtische Wärmeinseln',
                        'description' => 'Betonlastige Viertel leiden im Sommer unter extremer Hitze aufgrund fehlender Beschattung, Grünflächen und wasserdurchlässiger Oberflächen. Die Oberflächentemperaturen in diesen Gebieten können die umliegenden ländlichen Zonen um 5–8°C überschreiten, was Gesundheitsrisiken für gefährdete Bewohner birgt.',
                    ],
                    [
                        'language_id' => 22,
                        'title' => 'Islas de Calor Urbano',
                        'description' => 'Los barrios con mucho hormigón sufren calor extremo en verano debido a la falta de sombra, espacios verdes y superficies permeables. Las temperaturas superficiales en estas zonas pueden superar las zonas rurales circundantes en 5–8°C, lo que supone riesgos para la salud de los residentes vulnerables.',
                    ],
                    [
                        'language_id' => 10,
                        'title' => 'Îlots de Chaleur Urbains',
                        'description' => 'Les quartiers très bétonnés souffrent de chaleurs extrêmes en été en raison du manque d\'ombre, d\'espaces verts et de surfaces perméables. Les températures de surface dans ces zones peuvent dépasser les zones rurales environnantes de 5 à 8°C, posant des risques sanitaires pour les résidents vulnérables.',
                    ],
                ],
            ],
            // Project 3 — Digital Democracy — 2 published problems
            [
                'id' => 4,
                'project_id' => 3,
                'slug' => 'low-voter-engagement',
                'status_id' => ProblemStatusLkp::PUBLISHED,
                'img_url' => '/images/problems/problem-4.webp',
                'default_language_id' => 6,
                'user_creator_id' => 3,
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'Low Voter Engagement in Local Elections',
                        'description' => 'Participation in local elections rarely exceeds 40%, leaving major decisions in the hands of a minority. Many citizens feel disconnected from local governance and believe their vote has little impact on decisions that directly affect their daily lives.',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Χαμηλή Συμμετοχή Ψηφοφόρων στις Τοπικές Εκλογές',
                        'description' => 'Η συμμετοχή στις τοπικές εκλογές σπάνια ξεπερνά το 40%, αφήνοντας σημαντικές αποφάσεις στα χέρια μειοψηφίας. Πολλοί πολίτες αισθάνονται αποξενωμένοι από την τοπική διακυβέρνηση.',
                    ],
                    [
                        'language_id' => 11,
                        'title' => 'Geringe Wahlbeteiligung bei Kommunalwahlen',
                        'description' => 'Die Wahlbeteiligung bei Kommunalwahlen übersteigt selten 40%, wodurch wichtige Entscheidungen in den Händen einer Minderheit liegen. Viele Bürger fühlen sich von der lokalen Verwaltung abgekoppelt und glauben, dass ihre Stimme wenig Einfluss auf Entscheidungen hat, die ihr tägliches Leben direkt betreffen.',
                    ],
                    [
                        'language_id' => 22,
                        'title' => 'Baja Participación Electoral en Elecciones Locales',
                        'description' => 'La participación en las elecciones locales rara vez supera el 40%, dejando decisiones importantes en manos de una minoría. Muchos ciudadanos se sienten desconectados de la gobernanza local y creen que su voto tiene poco impacto en las decisiones que afectan directamente a su vida cotidiana.',
                    ],
                    [
                        'language_id' => 10,
                        'title' => 'Faible Participation Électorale aux Élections Locales',
                        'description' => 'La participation aux élections locales dépasse rarement 40%, laissant les décisions importantes entre les mains d\'une minorité. De nombreux citoyens se sentent déconnectés de la gouvernance locale et estiment que leur vote a peu d\'impact sur les décisions qui affectent directement leur vie quotidienne.',
                    ],
                ],
            ],
            [
                'id' => 5,
                'project_id' => 3,
                'slug' => 'digital-exclusion-elderly',
                'status_id' => ProblemStatusLkp::PUBLISHED,
                'img_url' => '/images/problems/problem-5.webp',
                'default_language_id' => 6,
                'user_creator_id' => 4,
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'Digital Exclusion of Elderly Citizens',
                        'description' => 'Many elderly residents cannot access digital public services or participate in online civic processes. As more government services move online, this group risks being left behind and losing their voice in decisions that affect them most.',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Ψηφιακός Αποκλεισμός Ηλικιωμένων Πολιτών',
                        'description' => 'Πολλοί ηλικιωμένοι κάτοικοι δεν μπορούν να έχουν πρόσβαση σε ψηφιακές δημόσιες υπηρεσίες ή να συμμετάσχουν σε ηλεκτρονικές διαδικασίες. Καθώς περισσότερες υπηρεσίες μεταφέρονται online, αυτή η ομάδα κινδυνεύει να αποκλειστεί.',
                    ],
                    [
                        'language_id' => 11,
                        'title' => 'Digitaler Ausschluss älterer Bürger',
                        'description' => 'Viele ältere Bewohner können nicht auf digitale öffentliche Dienste zugreifen oder an Online-Bürgerprozessen teilnehmen. Da immer mehr staatliche Dienste online gehen, läuft diese Gruppe Gefahr, abgehängt zu werden und ihre Stimme in Entscheidungen, die sie am meisten betreffen, zu verlieren.',
                    ],
                    [
                        'language_id' => 22,
                        'title' => 'Exclusión Digital de los Ciudadanos Mayores',
                        'description' => 'Muchos residentes mayores no pueden acceder a servicios públicos digitales ni participar en procesos cívicos en línea. A medida que más servicios gubernamentales se trasladan en línea, este grupo corre el riesgo de quedarse atrás y perder su voz en las decisiones que más les afectan.',
                    ],
                    [
                        'language_id' => 10,
                        'title' => 'Exclusion Numérique des Citoyens Âgés',
                        'description' => 'De nombreux résidents âgés ne peuvent pas accéder aux services publics numériques ni participer aux processus civiques en ligne. À mesure que de plus en plus de services gouvernementaux passent en ligne, ce groupe risque d\'être laissé pour compte et de perdre sa voix dans les décisions qui les touchent le plus.',
                    ],
                ],
            ],
            // Project 4 — Smart Cities 2030 — 2 finalized problems
            [
                'id' => 6,
                'project_id' => 4,
                'slug' => 'smart-waste-management',
                'status_id' => ProblemStatusLkp::FINALIZED,
                'img_url' => '/images/problems/problem-6.webp',
                'default_language_id' => 6,
                'user_creator_id' => 1,
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'Inefficient Waste Collection Routes',
                        'description' => 'Traditional waste collection runs on fixed schedules regardless of actual bin fill levels, wasting fuel, labour, and resources. Bins overflow before collection while trucks make unnecessary rounds to half-empty containers.',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Αναποτελεσματικές Διαδρομές Συλλογής Απορριμμάτων',
                        'description' => 'Η παραδοσιακή αποκομιδή ακολουθεί σταθερά δρομολόγια ανεξαρτήτως επιπέδου πλήρωσης των κάδων, σπαταλώντας καύσιμα και πόρους. Κάδοι υπερχειλίζουν ενώ τα φορτηγά επισκέπτονται μισοάδειους κάδους.',
                    ],
                ],
            ],
            [
                'id' => 7,
                'project_id' => 4,
                'slug' => 'smart-street-lighting',
                'status_id' => ProblemStatusLkp::FINALIZED,
                'img_url' => '/images/problems/problem-7.webp',
                'default_language_id' => 6,
                'user_creator_id' => 1,
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'Static Street Lighting Wastes Energy',
                        'description' => 'Street lights operate at full power throughout the night regardless of pedestrian activity or traffic volume. This static approach wastes significant energy and budget in hours when reduced lighting would be sufficient and safe.',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Στατικός Φωτισμός Δρόμων Σπαταλά Ενέργεια',
                        'description' => 'Τα φώτα του δρόμου λειτουργούν σε πλήρη ισχύ όλη νύχτα ανεξαρτήτως κίνησης πεζών ή οχημάτων. Αυτή η στατική προσέγγιση σπαταλά σημαντική ενέργεια και προϋπολογισμό σε ώρες που μειωμένος φωτισμός θα ήταν επαρκής.',
                    ],
                ],
            ],
        ];

        foreach ($problems as $problem) {
            Problem::updateOrCreate(['id' => $problem['id']], [
                'id' => $problem['id'],
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
