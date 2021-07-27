<?php


namespace App\Repository;


use App\Models\CrowdSourcingProject\CrowdSourcingProjectCommunicationResources;;

class CrowdSourcingProjectCommunicationResourcesRepository extends Repository {

    /**
     * @inheritDoc
     */
    function getModelClassName() {
        return CrowdSourcingProjectCommunicationResources::class;
    }
}
