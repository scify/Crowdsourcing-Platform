<?php


namespace App\BusinessLogicLayer;


use App\Models\CrowdSourcingProject;
use App\Models\CrowdSourcingProjectCommunicationResources;
use App\Repository\CrowdSourcingProjectCommunicationResourcesRepository;
use App\Repository\CrowdSourcingProjectRepository;

class CrowdSourcingProjectCommunicationResourcesManager {

    protected $crowdSourcingProjectCommunicationResourcesRepository;
    protected $crowdSourcingProjectRepository;

    public function __construct(CrowdSourcingProjectCommunicationResourcesRepository $crowdSourcingProjectCommunicationResourcesRepository,
                                CrowdSourcingProjectRepository$crowdSourcingProjectRepository) {
        $this->crowdSourcingProjectCommunicationResourcesRepository = $crowdSourcingProjectCommunicationResourcesRepository;
        $this->crowdSourcingProjectRepository = $crowdSourcingProjectRepository;
    }


    public function createOrUpdateCommunicationResourcesForProject(CrowdSourcingProject $project, array $data) {
        // if the project has already a communication resource, update it,
        if($project->communicationResources()->exists()) {
            $this->crowdSourcingProjectCommunicationResourcesRepository->update($data, $project->communication_resources_id);
        }
        // otherwise, create it and store it for the project
        else {
            $communicationResourcesId = $this->crowdSourcingProjectCommunicationResourcesRepository->create($data)->id;
            $this->crowdSourcingProjectRepository->update(['communication_resources_id' => $communicationResourcesId], $project->id);
        }

    }

    public function getDefaultModelInstance(): CrowdSourcingProjectCommunicationResources {
        $instance = $this->crowdSourcingProjectCommunicationResourcesRepository->getModelInstance();
        $instance->questionnaire_response_email_intro_text = 'Thanks to your contribution we are one step closer to our goal!';
        $instance->questionnaire_response_email_outro_text = 'If you have any inquiries about our work, do not hesitate to contact us.';
        return $instance;
    }

}
