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
                'user_creator_id' => 1,
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
                'user_creator_id' => 1,
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
                'user_creator_id' => 1,
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
                'id' => 6,
                'project_id' => 1,
                'slug' => 'european-elections-problem-4',
                'status_id' => CrowdSourcingProjectProblemStatusLkp::DRAFT,
                'img_url' => 'https://placehold.co/600x400',
                'default_language_id' => 6,
                'user_creator_id' => 1,
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'EU Elections Problem 4',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem ratione vitae, eum numquam autem optio amet pariatur ab quisquam sit ad dolor eius magnam repellat sunt perferendis ipsum expedita. Maxime?',
                    ],
                    [
                        'language_id' => 12,
                        'title' => 'Εκλογές EU Πρόβλημα 4',
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
                'user_creator_id' => 1,
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
                'user_creator_id' => 1,
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
        ];

        foreach ($problems as $problem) {
            // if the problem already exists but is soft deleted, restore it
            if ($existingProblem = CrowdSourcingProjectProblem::withTrashed()->find($problem['id'])) {
                $existingProblem->restore();
            }
            CrowdSourcingProjectProblem::updateOrCreate(['id' => $problem['id']], [
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
