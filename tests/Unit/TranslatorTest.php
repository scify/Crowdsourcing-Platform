<?php


namespace Tests\Unit;


use App\BusinessLogicLayer\questionnaire\QuestionnaireTranslator;
use App\Utils\Translator;
use Tests\TestCase;

class TranslatorTest extends TestCase {

    protected $translator;

    protected function setUp(): void {
        parent::setUp();
        $this->translator = $this->app->make(Translator::class);
    }

    public function test_translator_service() {
        $translated = $this->translator->translateTexts(
            [
                'Καλημέρα',
                'Καληνύχτα'
            ],
            'en'
        );
        self::assertEquals($translated[0]['text'], 'good morning');
    }

    public function test_translate_single_question() {
        $questionnaireTranslator = $this->app->make(QuestionnaireTranslator::class);
        $locales = ["", "de", "el", "fr"];
        $question = [
            'type' => 'rating',
            'name' => 'question4',
            'title' => 'Rating question',
            'rateMax' => 7,
            'minRateDescription' => 'This is the minimum',
            'maxRateDescription' => 'This is the maximum',
        ];
        $translatedQuestion = $questionnaireTranslator->translateQuestion($question, $locales);

        self::assertEquals($translatedQuestion, $question);

    }

    public function test_translate_questionnaire() {
        $questionnaireTranslator = $this->app->make(QuestionnaireTranslator::class);
        $locales = ["", "de", "el", "fr"];
        $json = '
             {
                 "title": "sdfgsdfg",
                 "description": "3412341234",
                 "logo": "sdfg",
                 "completedHtml": "1234213412",
                 "completedBeforeHtml": "4124214",
                 "loadingHtml": "sdfgsdfg",
                 "pages": [
                  {
                   "name": "page1",
                   "elements": [
                    {
                     "type": "rating",
                     "name": "question4",
                     "title": "Rating question",
                     "description": "r4r3r3r",
                     "requiredErrorText": "34r34r34r",
                     "commentText": "234r34",
                     "rateMax": 7,
                     "minRateDescription": "This is the minimum",
                     "maxRateDescription": "This is the maximum"
                    },
                    {
                     "type": "radiogroup",
                     "name": "question3",
                     "title": "Is this a question?",
                     "description": "werfewrf",
                     "requiredErrorText": "ewrfewrf",
                     "commentText": "ewrfewrf",
                     "choices": [
                      {
                       "value": "item1",
                       "text": "First"
                      },
                      {
                       "value": "item2",
                       "text": "Second"
                      },
                      {
                       "value": "item3",
                       "text": "Third"
                      }
                     ],
                     "otherPlaceHolder": "wefewrf",
                     "noneText": "ewrfewrf",
                     "otherText": "ewrfewrf",
                     "otherErrorText": "werfewf"
                    },
                    {
                     "type": "text",
                     "name": "question1",
                     "title": "First question",
                     "description": "sdgfsdfg",
                     "requiredErrorText": "dsfgdsfg",
                     "minErrorText": "dsfgdsfg",
                     "maxErrorText": "dsfgsdfg",
                     "placeHolder": "dsfgdsfg",
                     "dataList": [
                      "dsfgsdfg"
                     ]
                    },
                    {
                     "type": "matrix",
                     "name": "question2",
                     "title": "Matrix question here",
                     "description": "wfw",
                     "requiredErrorText": "fweferf",
                     "columns": [
                      {
                       "value": "Column 1",
                       "text": "First col"
                      },
                      {
                       "value": "Column 2",
                       "text": "Second col"
                      },
                      {
                       "value": "Column 3",
                       "text": "Third"
                      }
                     ],
                     "rows": [
                      {
                       "value": "Row 1",
                       "text": "first row!"
                      },
                      {
                       "value": "Row 2",
                       "text": "Second row here"
                      }
                     ]
                    }
                   ],
                   "title": "sdfgdsfg",
                   "description": "dfgsdfg",
                   "navigationTitle": "sdfgsdfg",
                   "navigationDescription": "dsfgsdfg"
                  }
                 ],
                 "startSurveyText": "sdfgsdfg",
                 "pagePrevText": "sdfgsdfg",
                 "pageNextText": "sdfgsdfg",
                 "completeText": "34213412",
                 "previewText": "dsfgsdfg",
                 "editText": "agasdfg"
                }
        ';

        $expected = '{"pages":[{"name":"page1","elements":[{"type":"rating","name":"question4","title":{"default":"Rating question","de":"Bewertungsfrage","el":"\u0395\u03c1\u03ce\u03c4\u03b7\u03c3\u03b7 \u03b1\u03be\u03b9\u03bf\u03bb\u03cc\u03b3\u03b7\u03c3\u03b7\u03c2","fr":"Question d&#39;\u00e9valuation"},"rateMax":7,"minRateDescription":{"default":"This is the minimum","de":"Das ist das Minimum","el":"\u0391\u03c5\u03c4\u03cc \u03b5\u03af\u03bd\u03b1\u03b9 \u03c4\u03bf \u03b5\u03bb\u03ac\u03c7\u03b9\u03c3\u03c4\u03bf","fr":"C&#39;est le minimum"},"maxRateDescription":{"default":"This is the maximum","de":"Das ist das Maximum","el":"\u0391\u03c5\u03c4\u03cc \u03b5\u03af\u03bd\u03b1\u03b9 \u03c4\u03bf \u03bc\u03ad\u03b3\u03b9\u03c3\u03c4\u03bf","fr":"C&#39;est le maximum"}},{"type":"radiogroup","name":"question3","title":{"default":"Is this a question?","de":"Ist das eine Frage?","el":"\u0395\u03af\u03bd\u03b1\u03b9 \u03b5\u03c1\u03ce\u03c4\u03b7\u03c3\u03b7;","fr":"Est-ce une question ?"},"choices":[{"value":"item1","text":{"default":"First","de":"Zuerst","el":"\u03a0\u03c1\u03ce\u03c4\u03b1","fr":"D&#39;abord"}},{"value":"item2","text":{"default":"Second","de":"Sekunde","el":"\u0394\u03b5\u03cd\u03c4\u03b5\u03c1\u03bf\u03c2","fr":"Seconde"}},{"value":"item3","text":{"default":"Third","de":"Dritter","el":"\u03a4\u03c1\u03af\u03c4\u03bf\u03c2","fr":"Troisi\u00e8me"}}]},{"type":"text","name":"question1","title":{"default":"First question","de":"Erste Frage","el":"\u03a0\u03c1\u03ce\u03c4\u03b7 \u03b5\u03c1\u03ce\u03c4\u03b7\u03c3\u03b7","fr":"Premi\u00e8re question"}},{"type":"matrix","name":"question2","title":{"default":"Matrix question here","de":"Matrixfrage hier","el":"\u0395\u03c1\u03ce\u03c4\u03b7\u03c3\u03b7 \u03bc\u03ae\u03c4\u03c1\u03b1\u03c2 \u03b5\u03b4\u03ce","fr":"Question matricielle ici"},"columns":[{"value":"Column 1","text":{"default":"First col","de":"Erste Farbe","el":"\u03a0\u03c1\u03ce\u03c4\u03bf \u03ba\u03bf\u03bb","fr":"Premier col"}},{"value":"Column 2","text":{"default":"Second col","de":"Zweite Farbe","el":"\u0394\u03b5\u03cd\u03c4\u03b5\u03c1\u03bf \u03ba\u03bf\u03bb","fr":"Deuxi\u00e8me col"}},{"value":"Column 3","text":{"default":"Third","de":"Dritter","el":"\u03a4\u03c1\u03af\u03c4\u03bf\u03c2","fr":"Troisi\u00e8me"}}],"rows":[{"value":"Row 1","text":{"default":"first row!","de":"erste Reihe!","el":"\u03c0\u03c1\u03ce\u03c4\u03b7 \u03c3\u03b5\u03b9\u03c1\u03ac!","fr":"premi\u00e8re rang\u00e9e!"}},{"value":"Row 2","text":{"default":"Second row here","de":"Zweite Reihe hier","el":"\u0394\u03b5\u03cd\u03c4\u03b5\u03c1\u03b7 \u03c3\u03b5\u03b9\u03c1\u03ac \u03b5\u03b4\u03ce","fr":"Deuxi\u00e8me rang\u00e9e ici"}}]}]}]}';
        $translatedJSON = $questionnaireTranslator->translateQuestionnaireJSONToLocales($json, $locales);
        $this->assertEquals($translatedJSON, $expected);
    }

}
