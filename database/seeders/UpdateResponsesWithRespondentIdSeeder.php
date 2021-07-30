<?php

namespace Database\Seeders;

use App\Models\Questionnaire\QuestionnaireResponse;
use Illuminate\Database\Seeder;

class UpdateResponsesWithRespondentIdSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $responses = QuestionnaireResponse::all();
        foreach ($responses as $response) {
            $obj = json_decode($response->response_json);
            $obj->respondent_user_id = $response->user_id;
            $response->response_json = json_encode($obj);
            $response->save();
        }
    }
}
