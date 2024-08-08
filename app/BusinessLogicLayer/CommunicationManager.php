<?php

namespace App\BusinessLogicLayer;

use App\Repository\MailChimpListRepository;
use App\ViewModels\MailChimpIntegration;

class CommunicationManager {
    private MailChimpListRepository $mailChimpListRepository;

    public function __construct(MailChimpListRepository $mailChimpListRepository) {
        $this->mailChimpListRepository = $mailChimpListRepository;
    }

    public function getMailChimpIntegrationViewModel(): MailChimpIntegration {
        $mailChimpLists = $this->mailChimpListRepository->all();

        return new MailChimpIntegration($mailChimpLists);
    }

    public function storeMailChimpListIds($registeredUsers): void {
        $this->mailChimpListRepository->storeMailChimpListIds($registeredUsers);
    }
}
