<?php

namespace App\Repository;

use App\Models\MailChimpList;
use Illuminate\Support\Facades\DB;

class MailChimpListRepository extends Repository {
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function getModelClassName() {
        return MailChimpList::class;
    }

    public function storeMailChimpListIds($registeredUsers): void {
        DB::transaction(function () use ($registeredUsers) {
            /*  $this->update(['list_id' => $newsletter], 1); // Newsletter*/
            $this->update(['list_id' => $registeredUsers], 2); // Registered Users
        });
    }
}
