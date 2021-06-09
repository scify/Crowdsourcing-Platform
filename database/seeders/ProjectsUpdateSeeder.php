<?php

namespace Database\Seeders;

use App\BusinessLogicLayer\CrowdSourcingProjectManager;
use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use Illuminate\Database\Seeder;

class ProjectsUpdateSeeder extends Seeder {

    private $crowdSourcingProjectManager;

    public function __construct(CrowdSourcingProjectManager $crowdSourcingProjectManager) {
        $this->crowdSourcingProjectManager = $crowdSourcingProjectManager;
    }


    public function run() {

        // if the table has not been populated yet
        $allProjectStatuses = \App\Models\CrowdSourcingProjectStatusLkp::all();
        if($allProjectStatuses->isEmpty())
            $this->call([
                CrowdSourcingProjectStatusesLkpTableSeeder::class
            ]);

        // take all projects that are not deleted
        $projects = $this->crowdSourcingProjectManager->getAllCrowdSourcingProjects();

        foreach ($projects as $project) {
            $attributesToBeUpdated = [];

            $project = $this->crowdSourcingProjectManager->populateInitialValuesForProjectIfNotSet($project);
            $project->status_id = CrowdSourcingProjectStatusLkp::PUBLISHED;
            // if project is fair-eu
            if($project->id == 2) {
                $project->img_path = '/images/projects/fair-eu/fair-eu-bg.png';
                $project->logo_path = '/images/projects/fair-eu/fair-eu.png';
                $project->sm_featured_img_path = '/images/projects/fair-eu/fair-eu.png';
            }
            $project->save();
            $fillableAttributes = $project->getFillable();

            $allProjectAttributes = $project->attributesToArray();

            foreach ($allProjectAttributes as $attributeName => $attributeValue) {
                if(in_array($attributeName, $fillableAttributes))
                    $attributesToBeUpdated[$attributeName] = $attributeValue;
            }

            $this->crowdSourcingProjectManager->updateCrowdSourcingProject($project->id, $attributesToBeUpdated);
        }
    }
}
