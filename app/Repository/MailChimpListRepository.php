<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 8/6/18
 * Time: 12:56 PM
 */

namespace App\Repository;


use App\Models\MailChimpList;
use Illuminate\Support\Facades\DB;

class MailChimpListRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function getModelClassName()
    {
        return MailChimpList::class;
    }

    public function storeMailChimpListIds($newsletter, $registeredUsers)
    {
        DB::transaction(function () use ($newsletter, $registeredUsers) {
            $this->update(['list_id' => $newsletter], 1); // Newsletter
            $this->update(['list_id' => $registeredUsers], 2); // Registered Users
        });
    }
}