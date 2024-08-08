<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 8/6/18
 * Time: 12:55 PM
 */

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MailChimpList
 *
 * @property int $id
 * @property string $list_name
 * @property string $list_id
 * @mixin Eloquent
 */
class MailChimpList extends Model {
    protected $table = 'mailchimp_lists';
    public $timestamps = false;
}
