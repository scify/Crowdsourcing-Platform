<?php

namespace Tests\Feature\Controllers\Questionnaire;

use App\BusinessLogicLayer\questionnaire\QuestionnaireResponseManager;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\TestCase;

class QuestionnaireTests extends TestCase {
    protected QuestionnaireResponseManager $questionnaireResponseManager;

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void {
        parent::setUp();
        $this->questionnaireResponseManager = $this->app->make(QuestionnaireResponseManager::class);
    }

    /**
     * @test
     */
    public function test_questionnaire_free_type_questions() {
        $questionnaireJSON = '
        {
           "pages":[
              {
                 "name":"page1",
                 "elements":[
                    {
                       "type":"rating",
                       "name":"question1",
                       "title":{
                          "default":"Rating question",
                          "de":"asdfasdf",
                          "da":"asdfasdf",
                          "el":"asdfsadf"
                       }
                    },
                    {
                       "type":"radiogroup",
                       "name":"question5",
                       "title":"Radio group",
                       "choices":[
                          "item1",
                          "item2",
                          "item3"
                       ],
                       "hasOther":true
                    },
                    {
                       "type":"multipletext",
                       "name":"question4",
                       "title":{
                          "default":"Multiple free text",
                          "de":"German multiple",
                          "da":"Danish multiple",
                          "el":"\u0395\u03bb\u03bb\u03b7\u03bd\u03b9\u03ba\u03cc multiple"
                       },
                       "items":[
                          {
                             "name":"text1",
                             "title":{
                                "default":"Text first",
                                "de":"sdfwf",
                                "da":"qwfwdf",
                                "el":"23322332"
                             }
                          },
                          {
                             "name":"text2",
                             "title":{
                                "default":"Second text",
                                "de":"23r23",
                                "da":"23qd23d",
                                "el":"2q3d2q3d"
                             }
                          }
                       ]
                    },
                    {
                       "type":"text",
                       "name":"question2",
                       "title":{
                          "default":"SImple input question",
                          "el":"\u0395\u03c1\u03ce\u03c4\u03b7\u03c3\u03b7 \u03b5\u03bb\u03b5\u03cd\u03b8\u03b5\u03c1\u03b7",
                          "da":"Danish question text",
                          "de":"German question text"
                       }
                    },
                    {
                       "type":"matrix",
                       "name":"question3",
                       "title":"Matrix question",
                       "columns":[
                          "First",
                          "Second",
                          "Third"
                       ],
                       "rows":[
                          "One",
                          "Two"
                       ]
                    }
                 ],
                 "title":{
                    "default":"This is the first page",
                    "el":"\u03a0\u03c1\u03ce\u03c4\u03b7 \u03c3\u03b5\u03bb\u03af\u03b4\u03b1",
                    "da":"afafd",
                    "de":"asdfasdfsadf"
                 }
              }
           ]
        }
        ';
        $responseJSON = '
        {
           "question1":3,
           "question5":"other",
           "question2":"DSSAdasdasd",
           "question3":{
              "Two":"First",
              "One":"Second"
           },
           "question5-Comment":"Test test test test"
        }
        ';

        $freeTypeQuestions = $this->questionnaireResponseManager->getFreeTypeQuestionsFromQuestionnaireJSON($questionnaireJSON);

        $answers = json_decode($responseJSON);

        foreach ($answers as $questionName => $answer) {
            if (isset($freeTypeQuestions[$questionName])) {
                self::assertEquals($questionName, $freeTypeQuestions[$questionName]->name);
            }
        }
    }
}
