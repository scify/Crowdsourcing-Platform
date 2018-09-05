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

        $registeredUsersListId =  $mailChimpLists->where('id', "=",2)->first()->list_id;

       /* $MailChimp = new MailChimp(env('MAILCHIMP_API_KEY'));
        $result = $MailChimp->post("lists/7e4cb2929e/members", [
            'email_address' => $email,
            'status'        => 'subscribed',
            'FNAME'      => $firstName
        ]);*/



        $config = $this->generateNewsletterListConfiguration( "7e4cb2929e");
        $this->newsletterManager = new Newsletter(new MailChimp(env('MAILCHIMP_API_KEY')), NewsletterListCollection::createFromConfig($config));

        $mergeFields = [];
        if ($firstName)
            $mergeFields['FNAME'] = $firstName;
        if (!$this->newsletterManager->isSubscribed($email, $listName))
            $this->newsletterManager->subscribeOrUpdate($email, $mergeFields, $listName);
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