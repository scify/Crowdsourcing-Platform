<?php

namespace Database\Seeders;

use App\Repository\CrowdSourcingProject\CrowdSourcingProjectColorsRepository;
use Illuminate\Database\Seeder;

class CrowdSourcingProjectColorsSeeder extends Seeder {
    protected CrowdSourcingProjectColorsRepository $crowdSourcingProjectColorsRepository;

    public function __construct(CrowdSourcingProjectColorsRepository $crowdSourcingProjectColorsRepository) {
        $this->crowdSourcingProjectColorsRepository = $crowdSourcingProjectColorsRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $colors = [
            [
                'color_name' => 'color-01',
                'color_code' => '#004F9F',
            ],
            [
                'color_name' => 'color-02',
                'color_code' => '#28A745',
            ],
            [
                'color_name' => 'color-03',
                'color_code' => '#DC3545',
            ],
            [
                'color_name' => 'color-04',
                'color_code' => '#FD7E14',
            ],
            [
                'color_name' => 'color-05',
                'color_code' => '#FFC107',
            ],
            [
                'color_name' => 'color-06',
                'color_code' => '#20C997',
            ],
            [
                'color_name' => 'color-07',
                'color_code' => '#E83E8C',
            ],
            [
                'color_name' => 'color-08',
                'color_code' => '#29B6F6',
            ],
            [
                'color_name' => 'color-09',
                'color_code' => '#6610F2',
            ],
            [
                'color_name' => 'color-10',
                'color_code' => '#8D6E63',
            ],
            [
                'color_name' => 'color-11',
                'color_code' => '#78909C',
            ],
        ];

        foreach ($colors as $color) {
            $this->crowdSourcingProjectColorsRepository->updateOrCreate([
                'project_id' => null,
                'color_name' => $color['color_name'],
            ], $color);
        }
        // only echo if not in test environment
        if (app()->environment() !== 'testing') {
            echo "\nDefault colors were created.\n";
        }
    }
}
