<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\MailChimpList;
use Illuminate\Support\Facades\DB;

class MailChimpListRepository extends Repository {
    /**
     * Specify Model class name
     */
    public function getModelClassName(): string {
        return MailChimpList::class;
    }

    public function storeMailChimpListIds($registeredUsers): void {
        DB::transaction(function () use ($registeredUsers): void {
            /*  $this->update(['list_id' => $newsletter], 1); // Newsletter */
            $this->update(['list_id' => $registeredUsers], 2); // Registered Users
        });
    }
}
