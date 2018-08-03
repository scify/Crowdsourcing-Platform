<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 8/3/18
 * Time: 4:15 PM
 */

namespace App\Http\Controllers;


class CommunicationController extends Controller
{
    public function getMailChimpIntegration()
    {
        return view('mailchimp-integration');
    }
}