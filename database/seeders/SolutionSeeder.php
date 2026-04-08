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
                    [
                        'language_id' => 11,
                        'title' => 'Park-and-Ride-System ausbauen',
                        'description' => 'Entwicklung dedizierter Park-and-Ride-Knotenpunkte an den wichtigsten Stadteinfahrten mit häufigen, kostenlosen Pendelbus-Verbindungen ins Zentrum. Dies entfernt Autos, bevor sie in überfüllte Bereiche gelangen, und bietet eine bequeme, nachhaltige Alternative zum Parken in der Innenstadt.',
                    ],
                    [
                        'language_id' => 22,
                        'title' => 'Ampliar el Sistema Park-and-Ride',
                        'description' => 'Desarrollar centros park-and-ride dedicados en los principales puntos de entrada a la ciudad con autobuses lanzadera frecuentes y gratuitos al centro. Esto elimina los coches antes de que entren en zonas congestionadas y ofrece una alternativa conveniente y sostenible al aparcamiento en el centro urbano.',
                    ],
                    [
                        'language_id' => 10,
                        'title' => 'Développer le Système Park-and-Ride',
                        'description' => 'Développer des pôles park-and-ride dédiés aux principales entrées de la ville avec des navettes fréquentes et gratuites vers le centre. Cela élimine les voitures avant qu\'elles n\'entrent dans les zones congestionnées et offre une alternative pratique et durable au stationnement en centre-ville.',
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
                    [
                        'language_id' => 11,
                        'title' => 'Dynamische Parkgebühren einführen',
                        'description' => 'Echtzeit-Sensoren und variable Preisgestaltung verteilen die Nachfrage gleichmäßig auf alle verfügbaren Parkanlagen. Preise steigen in belebten Bereichen und sinken in weniger genutzten, was Fahrer zu freien Plätzen leitet und den Suchverkehr um schätzungsweise 30% reduziert.',
                    ],
                    [
                        'language_id' => 22,
                        'title' => 'Introducir Tarifas de Aparcamiento Dinámicas',
                        'description' => 'Usar sensores en tiempo real y precios variables para distribuir la demanda de forma uniforme en todas las instalaciones de aparcamiento disponibles. Los precios suben en zonas concurridas y bajan en las poco utilizadas, guiando a los conductores a plazas disponibles y reduciendo el tráfico de búsqueda en un estimado del 30%.',
                    ],
                    [
                        'language_id' => 10,
                        'title' => 'Instaurer une Tarification Dynamique du Stationnement',
                        'description' => 'Utiliser des capteurs en temps réel et une tarification variable pour répartir la demande uniformément dans toutes les infrastructures de stationnement disponibles. Les prix augmentent dans les zones fréquentées et baissent dans les moins utilisées, guidant les conducteurs vers les places disponibles et réduisant le trafic de recherche d\'environ 30%.',
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
                    [
                        'language_id' => 11,
                        'title' => 'Geschützte Fahrradspuren auf Hauptstraßen bauen',
                        'description' => 'Physisch getrennte Fahrradspuren auf den 10 belebtesten Korridoren würden sicheres Radfahren für alle Altersgruppen und Fähigkeiten ermöglichen. Bordsteingeschützte Spuren, eigene Ampeln und sichere Abstellanlagen an wichtigen Zielen würden das Radfahren für Pendler zur attraktiven Option machen.',
                    ],
                    [
                        'language_id' => 22,
                        'title' => 'Construir Carriles Bici Protegidos en Vías Principales',
                        'description' => 'Los carriles bici físicamente separados en los 10 corredores más transitados permitirían pedalear con seguridad a todas las edades y capacidades. Carriles protegidos por bordillos, semáforos dedicados y aparcamiento seguro en destinos clave harían del ciclismo una opción viable para los trabajadores diarios.',
                    ],
                    [
                        'language_id' => 10,
                        'title' => 'Aménager des Pistes Cyclables Protégées sur les Axes Principaux',
                        'description' => 'Des pistes cyclables physiquement séparées sur les 10 corridors les plus fréquentés permettraient de circuler à vélo en toute sécurité pour tous les âges et aptitudes. Des pistes protégées par des bordures, des feux dédiés et des stationnements sécurisés aux destinations clés rendraient le vélo viable pour les navetteurs quotidiens.',
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
                    [
                        'language_id' => 11,
                        'title' => 'Stadtweites Fahrrad-Sharing-Programm starten',
                        'description' => 'Ein Netz von 500+ Andockstationen mit E-Bikes würde das Radfahren für alle Pendler unabhängig von der körperlichen Fitness zugänglich machen. Minuten-Tarife und eine Monatsabo-Option würden sowohl gelegentliche als auch regelmäßige Nutzer bedienen.',
                    ],
                    [
                        'language_id' => 22,
                        'title' => 'Lanzar un Programa de Bicicletas Compartidas en Toda la Ciudad',
                        'description' => 'Una red de más de 500 estaciones de acoplamiento con bicicletas eléctricas haría el ciclismo accesible a todos los trabajadores independientemente de su condición física. La tarificación por minuto y una opción de suscripción mensual servirían tanto a usuarios ocasionales como habituales.',
                    ],
                    [
                        'language_id' => 10,
                        'title' => 'Lancer un Programme de Vélos en Libre-Service à l\'Échelle de la Ville',
                        'description' => 'Un réseau de 500+ stations d\'ancrage avec des vélos électriques rendrait le cyclisme accessible à tous les navetteurs quelle que soit leur condition physique. Une tarification à la minute et une option d\'abonnement mensuel serviraient à la fois les utilisateurs occasionnels et réguliers.',
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
                    [
                        'language_id' => 11,
                        'title' => 'Städtische Begrünungskorridore schaffen',
                        'description' => 'Baumpflanzungen alle 8 Meter entlang der Hauptstraßen und wasserdurchlässige Pflasterung zur Senkung der Oberflächentemperaturen um bis zu 4°C. Grüne Korridore verbessern zudem die Luftqualität, reduzieren den Regenwasserabfluss und spenden Fußgängern Schatten.',
                    ],
                    [
                        'language_id' => 22,
                        'title' => 'Crear Corredores de Urbanización Verde',
                        'description' => 'Plantar árboles cada 8 metros a lo largo de las calles principales e instalar pavimentos permeables que absorban el agua para reducir las temperaturas superficiales hasta 4°C. Los corredores verdes también mejoran la calidad del aire, reducen la escorrentía de aguas pluviales y proporcionan sombra a los peatones.',
                    ],
                    [
                        'language_id' => 10,
                        'title' => 'Créer des Corridors de Verdissement Urbain',
                        'description' => 'Planter des arbres tous les 8 mètres le long des artères principales et installer des pavés perméables absorbant l\'eau pour réduire les températures de surface jusqu\'à 4°C. Les corridors verts améliorent également la qualité de l\'air, réduisent le ruissellement des eaux pluviales et offrent de l\'ombre aux piétons.',
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
                    [
                        'language_id' => 11,
                        'title' => 'Vereinfachte digitale Wählerregistrierung',
                        'description' => 'Ein Online-Registrierungssystem per Klick, das mit der nationalen Ausweisdatenbank verknüpft ist, würde die größte bürokratische Hürde bei der Anmeldung beseitigen. Automatische Erinnerungen vor Wahlen und mobilfreundlicher Zugang würden die Registrierungsraten unter jungen Wählern deutlich steigern.',
                    ],
                    [
                        'language_id' => 22,
                        'title' => 'Registro Electoral Digital Simplificado',
                        'description' => 'Un sistema de registro en línea con un solo clic vinculado a la base de datos del DNI nacional eliminaría el mayor obstáculo burocrático para la inscripción. Los recordatorios automáticos antes de las elecciones y el acceso adaptado a móviles aumentarían significativamente las tasas de registro entre los jóvenes votantes.',
                    ],
                    [
                        'language_id' => 10,
                        'title' => 'Inscription Électorale Numérique Simplifiée',
                        'description' => 'Un système d\'inscription en ligne en un clic lié à la base de données nationale des cartes d\'identité supprimerait le plus grand obstacle bureaucratique à l\'enregistrement. Des rappels automatiques avant les élections et un accès adapté aux mobiles augmenteraient considérablement les taux d\'inscription parmi les jeunes électeurs.',
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
                    [
                        'language_id' => 11,
                        'title' => 'Programm zur politischen Bildung in Schulen',
                        'description' => 'Verbindliche Module zur Bürgerbeteiligung ab 14 Jahren würden eine Kultur demokratischen Engagements vor dem Wahlalter fördern. Praktische Übungen — wie Probewahlen, Besuche im Stadtrat und Planung kommunaler Projekte — bilden dauerhafte staatsbürgerliche Gewohnheiten.',
                    ],
                    [
                        'language_id' => 22,
                        'title' => 'Programa de Educación Cívica en las Escuelas',
                        'description' => 'Los módulos obligatorios de participación cívica a partir de los 14 años fomentarían una cultura de compromiso democrático antes de la edad de voto. Ejercicios prácticos — como elecciones simuladas, visitas al ayuntamiento local y planificación de proyectos comunitarios — generan hábitos cívicos duraderos.',
                    ],
                    [
                        'language_id' => 10,
                        'title' => 'Programme d\'Éducation Civique dans les Écoles',
                        'description' => 'Des modules obligatoires de participation civique à partir de 14 ans favoriseraient une culture d\'engagement démocratique avant l\'âge de voter. Des exercices pratiques — comme des élections simulées, des visites au conseil municipal et la planification de projets communautaires — forment des habitudes civiques durables.',
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
                    [
                        'language_id' => 11,
                        'title' => 'Kostenlose Zentren für digitale Kompetenz in Bibliotheken',
                        'description' => 'Betreute digitale Hilfsstellen in allen öffentlichen Bibliotheken mit vereinfachten Tablets und geduldiger Einzelbetreuung. Wöchentliche offene Sprechstunden zu Online-Behördendiensten, Videoanrufen und sicherem Surfen würden die digitale Kluft für Senioren überbrücken.',
                    ],
                    [
                        'language_id' => 22,
                        'title' => 'Centros Gratuitos de Alfabetización Digital en Bibliotecas',
                        'description' => 'Puntos de asistencia digital con personal en todas las bibliotecas públicas con tabletas simplificadas y orientación individual y paciente. Sesiones semanales abiertas que cubren servicios gubernamentales en línea, videollamadas y navegación segura reducirían la brecha digital para los mayores.',
                    ],
                    [
                        'language_id' => 10,
                        'title' => 'Centres Gratuits de Compétences Numériques dans les Bibliothèques',
                        'description' => 'Des espaces d\'assistance numérique dotés de personnel dans toutes les bibliothèques publiques, avec des tablettes simplifiées et un accompagnement individuel patient. Des sessions hebdomadaires ouvertes couvrant les services publics en ligne, les appels vidéo et la navigation sécurisée combleraient le fossé numérique pour les seniors.',
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
