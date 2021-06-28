<?php


namespace Tests\Feature;


use App\Repository\Questionnaire\QuestionnaireTranslationRepository;

class QuestionnaireTests extends \Tests\TestCase {

    protected $questionnaireTranslationRepository;

    protected function setUp(): void {
        parent::setUp();
        $this->questionnaireTranslationRepository = $this->app->make(QuestionnaireTranslationRepository::class);
    }

    public function test_questionnaire_get_translations_by_language_and_question() {

        $questionnaireJSON = '{
             "pages": [
              {
               "name": "page1",
               "elements": [
                {
                 "type": "text",
                 "name": "question7",
                 "title": "Test input"
                },
                {
                 "type": "multipletext",
                 "name": "question8",
                 "title": "Text multiple text input",
                 "items": [
                  {
                   "name": "text1",
                   "title": "question 1"
                  },
                  {
                   "name": "text2",
                   "title": "question 2"
                  }
                 ]
                },
                {
                 "type": "radiogroup",
                 "name": "question9",
                 "choices": [
                  "item1",
                  "item2",
                  "item3"
                 ],
                 "hasOther": true
                },
                {
                 "type": "html",
                 "name": "question1",
                 "html": {
                  "fr": "4325",
                  "gr": "ελληνικά εδώ",
                  "hu": "345345",
                  "default": "Blablalbbalblablalba"
                 }
                },
                {
                 "type": "rating",
                 "name": "question2",
                 "title": {
                  "fr": "sfafa",
                  "gr": "fadfsfa",
                  "hu": "sdfasdf"
                 }
                },
                {
                 "type": "matrix",
                 "name": "question4",
                 "title": {
                  "fr": "asdfasf",
                  "gr": "asfasf",
                  "hu": "asdfasdf"
                 },
                 "columns": [
                  "Column 1",
                  "Column 2",
                  "Column 3"
                 ],
                 "rows": [
                  "Row 1",
                  "Row 2"
                 ]
                }
               ],
               "title": {
                "fr": "123",
                "gr": "ελληνικός τίτλος",
                "hu": "asdf",
                "default": "First page123"
               },
               "description": {
                "fr": "francais",
                "gr": "νεα ελληνικά",
                "hu": "asdf",
                "default": "this is the first page"
               }
              },
              {
               "name": "page2",
               "elements": [
                {
                 "type": "dropdown",
                 "name": "question5",
                 "title": {
                  "fr": "2ef2ef",
                  "gr": "2fe2ef",
                  "hu": "2ef2ef",
                  "default": "Dropdown question here"
                 },
                 "choices": [
                  {
                   "value": "item1",
                   "text": {
                    "fr": "2f",
                    "gr": "fe2",
                    "hu": "fe2"
                   }
                  },
                  {
                   "value": "item2",
                   "text": {
                    "fr": "2ef",
                    "gr": "f2e",
                    "hu": "e2f"
                   }
                  },
                  {
                   "value": "item3",
                   "text": {
                    "fr": "2ef",
                    "gr": "f2e",
                    "hu": "fe2"
                   }
                  }
                 ]
                },
                {
                 "type": "boolean",
                 "name": "question6",
                 "title": {
                  "fr": "2ef2ef",
                  "gr": "2ef2ef",
                  "hu": "e2f2ef",
                  "default": "Boolean question here"
                 }
                }
               ],
               "title": {
                "fr": "2ef2ef",
                "gr": "2ef",
                "hu": "2ef",
                "default": "This is the second page!"
               },
               "description": {
                "fr": "qef",
                "gr": "q2ef",
                "hu": "2f",
                "default": "Second page description"
               }
              }
             ]
             }';
        $questions = json_decode($questionnaireJSON);
        foreach ($questions['pages'] as $page) {

        }
    }
}
