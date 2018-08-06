<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 8/6/18
 * Time: 12:55 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class MailChimpList extends Model
{
    protected $table = 'mailchimp_lists';
    public $timestamps = false;
}