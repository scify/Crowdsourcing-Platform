<?php


use App\BusinessLogicLayer\CrowdSourcingProjectManager;
use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use Illuminate\Database\Seeder;

class PlatformSeederForV2 extends Seeder {

    private $crowdSourcingProjectManager;

    public function __construct(CrowdSourcingProjectManager $crowdSourcingProjectManager) {
        $this->crowdSourcingProjectManager = $crowdSourcingProjectManager;
    }


    public function run() {

        // if the table ahs not been populated yet
        $allProjectStatuses = \App\Models\CrowdSourcingProjectStatusLkp::all();
        if($allProjectStatuses->isEmpty())
            $this->call([
                CrowdSourcingProjectStatusesLkpTableSeeder::class
            ]);

        // take the current project from the DB and update it
        $project = $this->crowdSourcingProjectManager->getCrowdSourcingProject(1);

        $project->status_id = CrowdSourcingProjectStatusLkp::PUBLISHED;

        $project = $this->crowdSourcingProjectManager->populateInitialValuesForProjectIfNotSet($project);

        $fillableAttributes = $project->getFillable();

        $allProjectAttributes = $project->attributesToArray();

        $attributesToBeUpdated = [];

        foreach ($allProjectAttributes as $attributeName => $attributeValue) {
            if(in_array($attributeName, $fillableAttributes))
               $attributesToBeUpdated[$attributeName] = $attributeValue;
        }

        $attributesToBeUpdated['img_path'] = '/images/projects/fair-eu/fair-eu-bg.png';
        $attributesToBeUpdated['logo_path'] = '/images/projects/fair-eu/fair-eu.png';
        $attributesToBeUpdated['sm_featured_img_path'] = '/images/projects/fair-eu/fair-eu.png';

        $this->crowdSourcingProjectManager->updateCrowdSourcingProject($project->id, $attributesToBeUpdated);

    }
}
