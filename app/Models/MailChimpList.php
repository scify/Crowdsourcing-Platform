<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MailChimpList
 *
 * @property int $id
 * @property string $list_name
 * @property string $list_id
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailChimpList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailChimpList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailChimpList query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailChimpList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailChimpList whereListId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailChimpList whereListName($value)
 *
 * @mixin Eloquent
 */
class MailChimpList extends Model {
    protected $table = 'mailchimp_lists';

    public $timestamps = false;
}
