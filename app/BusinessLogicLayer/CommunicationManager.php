<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer;

use App\Repository\MailChimpListRepository;
use App\ViewModels\MailChimpIntegration;

class CommunicationManager {
    public function __construct(private readonly MailChimpListRepository $mailChimpListRepository) {}

    public function getMailChimpIntegrationViewModel(): MailChimpIntegration {
        $mailChimpLists = $this->mailChimpListRepository->all();

        return new MailChimpIntegration($mailChimpLists);
    }

    public function storeMailChimpListIds($registeredUsers): void {
        $this->mailChimpListRepository->storeMailChimpListIds($registeredUsers);
    }
}
