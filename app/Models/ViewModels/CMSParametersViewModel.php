<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 5/30/18
 * Time: 12:54 PM
 */

namespace App\Models\ViewModels;


class CMSParametersViewModel
{
    public $cms;
    public $socialMedia;

    public function __construct($cms, $socialMedia)
    {
        $this->cms = $cms;
        $this->socialMedia = $socialMedia;
    }
}