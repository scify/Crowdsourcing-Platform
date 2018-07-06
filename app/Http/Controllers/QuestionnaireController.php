<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/6/18
 * Time: 5:04 PM
 */

namespace App\Http\Controllers;


class QuestionnaireController extends Controller
{
    public function createQuestionnaire()
    {
        return view('create-questionnaire');
    }
}