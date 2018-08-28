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

    public function subscribe($email, $listName, $firstName = null)
    {
        $mailChimpLists = $this->mailChimpListRepository->all();
        if ($mailChimpLists->count() !== 2)
            return new \Exception('MailChimp list IDs were not configured in the appropriate DB table. Please run the appropriate seeder before trying again.');
        $newsletterListId = $mailChimpLists->where('list_name', 'Newsletter')->first()->list_id;
        $registeredUsersListId = $mailChimpLists->where('list_name', 'Registered Users')->first()->list_id;
        $config = $this->generateNewsletterListConfiguration($newsletterListId, $registeredUsersListId);
        $this->newsletterManager = new Newsletter(new MailChimp(env('MAILCHIMP_API_KEY')), NewsletterListCollection::createFromConfig($config));

        $mergeFields = [];
        if ($firstName)
            $mergeFields['FNAME'] = $firstName;
        if (!$this->newsletterManager->isSubscribed($email, $listName))
            $this->newsletterManager->subscribeOrUpdate($email, $mergeFields, $listName);
    }

    private function generateNewsletterListConfiguration($newsletterListId, $registeredUsersListId)
    {
        return [
            'defaultListName' => 'newsletter',
            'lists' => [
                'newsletter' => ['id' => $newsletterListId],
                'registered_users' => ['id' => $registeredUsersListId]
            ]
        ];
    }
}