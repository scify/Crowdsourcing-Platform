<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 8/1/18
 * Time: 5:05 PM
 */

namespace App\Http\Controllers;


class HomeController extends Controller
{
    public function index()
    {
        return view('crowdsourcing-landingpage.layout');
    }
}