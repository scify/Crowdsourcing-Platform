<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/5/18
 * Time: 3:48 PM
 */

namespace App\Repository;


use App\Models\Language;

class LanguageRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function getModelClassName()
    {
        return Language::class;
    }
}