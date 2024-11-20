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
            [
                'id' => 1,
                'problem_id' => 1, 
                'user_creator_id' => 1,
                'slug' => 'european-elections-problem-1-solution-1',
                'status_id' => SolutionStatusLkp::PUBLISHED,
                'img_url' => 'https://placehold.co/611x411',
                'translations' => [
                    [
                        'language_id' => 12,
                        'title' => 'Εκλογές EU Πρόβλημα 1 Λύση 1',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem ratione vitae, eum numquam autem optio amet pariatur ab quisquam sit ad dolor eius magnam repellat sunt perferendis ipsum expedita. Maxime?',
                    ],
                    [
                        'language_id' => 6,
                        'title' => 'EU Elections Problem 1 Sln 1',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem ratione vitae, eum numquam autem optio amet pariatur ab quisquam sit ad dolor eius magnam repellat sunt perferendis ipsum expedita. Maxime?',
                    ],
                ],
            ],
            [
                'id' => 2,
                'problem_id' => 1, 
                'user_creator_id' => 2,
                'slug' => 'european-elections-problem-1-solution-2',
                'status_id' => SolutionStatusLkp::PUBLISHED,
                'img_url' => 'https://placehold.co/621x421',
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'EU Elections Problem 1 Sln 2',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem ratione vitae, eum numquam autem optio amet pariatur ab quisquam sit ad dolor eius magnam repellat sunt perferendis ipsum expedita. Maxime?',
                    ],
                ],
            ],
            [
                'id' => 3,
                'problem_id' => 1, 
                'user_creator_id' => 3,
                'slug' => 'european-elections-problem-1-solution-3',
                'status_id' => SolutionStatusLkp::UNPUBLISHED,
                'img_url' => 'https://placehold.co/631x431',
                'translations' => [
                    [
                        'language_id' => 12,
                        'title' => 'Εκλογές EU Πρόβλημα 1 Λύση 3',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem ratione vitae, eum numquam autem optio amet pariatur ab quisquam sit ad dolor eius magnam repellat sunt perferendis ipsum expedita. Maxime?',
                    ],
                ],
            ],
            [
                'id' => 4,
                'problem_id' => 5, 
                'user_creator_id' => 3,
                'slug' => 'european-democracy-problem-2-solution-1',
                'status_id' => SolutionStatusLkp::PUBLISHED,
                'img_url' => 'https://placehold.co/615x415',
                'translations' => [
                    [
                        'language_id' => 6,
                        'title' => 'EU Democracy Problem 2 Sln 1',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem ratione vitae, eum numquam autem optio amet pariatur ab quisquam sit ad dolor eius magnam repellat sunt perferendis ipsum expedita. Maxime?',
                    ],
                ],
            ],
        ];

        foreach ($solutions as $solution) {
            Solution::updateOrCreate(['id' => $solution['id']], [
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
