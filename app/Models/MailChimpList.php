<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 8/6/18
 * Time: 12:55 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MailChimpList
 *
 * @property int $id
 * @property string $list_name
 * @property string $list_id
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MailChimpList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MailChimpList whereListId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MailChimpList whereListName($value)
 * @mixin \Eloquent
 */
class MailChimpList extends Model {
    protected $table = 'mailchimp_lists';
    public $timestamps = false;
}
