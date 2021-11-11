<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 8/6/18
 * Time: 12:02 PM
 */

namespace App\Utils;


use App\Repository\MailChimpListRepository;
use DrewM\MailChimp\MailChimp;
use Spatie\Newsletter\Newsletter;
use Spatie\Newsletter\NewsletterListCollection;

class MailChimpAdaptor
{
    private $newsletterManager;
    private $mailChimpListRepository;

    /**
     * MailChimpAdaptor constructor.
     * @param MailChimpListRepository $mailChimpListRepository
     * @throws \Exception
     */
    public function __construct(MailChimpListRepository $mailChimpListRepository)
    {
        $this->mailChimpListRepository = $mailChimpListRepository;
    }

    public function subscribe($email, $listName, $name)
    {
        if(config('app.mailchimp_api_key') && config('app.mailchimp_api_key') != "") {
            $mailChimpLists = $this->mailChimpListRepository->all();

            $registeredUsersListId = $mailChimpLists->where('id', "=", 2)->first()->list_id;
            $config = $this->generateNewsletterListConfiguration($registeredUsersListId);
            $this->newsletterManager = new Newsletter(new MailChimp(config('app.mailchimp_api_key')), NewsletterListCollection::createFromConfig($config));

            $mergeFields = [];
            if ($name)
                $mergeFields['FNAME'] = $name;
            if (!$this->newsletterManager->isSubscribed($email, $listName))
                $this->newsletterManager->subscribeOrUpdate($email, $mergeFields, $listName);
        }
    }

    private function generateNewsletterListConfiguration($registeredUsersListId)
    {
        return [
            'defaultListName' => 'registered_users',
            'lists' => [
                'registered_users' => ['id' => $registeredUsersListId]
            ]
        ];
    }
}
