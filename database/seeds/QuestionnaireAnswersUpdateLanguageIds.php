<?php

use Illuminate\Database\Seeder;

class QuestionnaireAnswersUpdateLanguageIds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            DB::raw('update questionnaire_responses set language_id =14 where user_id =75 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =17 where user_id =84 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =25 where user_id =89 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =10 where user_id =102 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =19 where user_id =107 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =14 where user_id =132 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =14 where user_id =136 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =22 where user_id =136 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =14 where user_id =147 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =19 where user_id =158 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =14 where user_id =187 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =19 where user_id =187 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =14 where user_id =199 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =10 where user_id =201 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =14 where user_id =209 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =19 where user_id =219 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =14 where user_id =286 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =14 where user_id =297 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =19 where user_id =297 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =14 where user_id =300 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =19 where user_id =300 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =18 where user_id =320 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =9 where user_id =322 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =19 where user_id =358 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =14 where user_id =368 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =17 where user_id =369 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =14 where user_id =375 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =14 where user_id =397 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =9 where user_id =410 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =14 where user_id =412 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =19 where user_id =412 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =14 where user_id =434 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =22 where user_id =434 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =9 where user_id =437 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =19 where user_id =455 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =9 where user_id =461 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =1 where user_id =472 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =14 where user_id =492 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =22 where user_id =492 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =17 where user_id =504 and questionnaire_id = 1;');
            DB::raw('update questionnaire_responses set language_id =7 where user_id =504 and questionnaire_id = 1;');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }
}
