<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 8/6/18
 * Time: 1:01 PM
 */

namespace App\BusinessLogicLayer;

use App\Models\ViewModels\MailChimpIntegration;
use App\Repository\MailChimpListRepository;
use App\Utils\MailChimpAdaptor;

class CommunicationManager {
    private $mailChimpListRepository;
    private $mailChimpManager;

    public function __construct(MailChimpListRepository $mailChimpListRepository, MailChimpAdaptor $mailChimpManager) {
        $this->mailChimpListRepository = $mailChimpListRepository;
        $this->mailChimpManager = $mailChimpManager;
    }

    public function getMailChimpIntegrationViewModel() {
        $mailChimpLists = $this->mailChimpListRepository->all();

        return new MailChimpIntegration($mailChimpLists);
    }

    public function storeMailChimpListIds($newsletter, $registeredUsers) {
        $this->mailChimpListRepository->storeMailChimpListIds($newsletter, $registeredUsers);
    }

    public function signUpForNewsletter($firstName, $email) {
        $this->mailChimpManager->subscribe($email, 'newsletter', $firstName);
    }
}
