<?php

namespace App\Repository\Questionnaire;


use App\Models\Language;
use App\Models\Questionnaire;
use App\Models\QuestionnaireLanguage;
use App\Models\QuestionnaireTranslationHtml;
use App\Models\QuestionnaireTranslationPossibleAnswer;
use App\Models\QuestionnaireTranslationQuestion;
use Illuminate\Support\Facades\DB;

class QuestionnaireTranslationRepository {

    public function deleteQuestionnaireTranslation(QuestionnaireLanguage $questionnaireLanguage) {
        DB::transaction(function () use ($questionnaireLanguage) {

            DB::delete('delete from questionnaire_translation_html where questionnaire_language_id = ' . $questionnaireLanguage->id);

            DB::delete('delete from questionnaire_translation_questions where questionnaire_language_id = ' . $questionnaireLanguage->id);

            DB::delete('delete from questionnaire_translation_possible_answers where questionnaire_language_id = ' . $questionnaireLanguage->id);

            DB::delete('delete from questionnaire_languages where id = ' . $questionnaireLanguage->id);

        });
    }

    public function deleteHtmlTranslations($htmlId) {
        QuestionnaireTranslationHtml::where('html_id', $htmlId)->delete();
    }

    public function getQuestionnaireAvailableLanguages($questionnaireId) {
        return QuestionnaireLanguage::where('questionnaire_id', $questionnaireId)->with('language')->get();
    }

    public function getQuestionnaireLanguage($questionnaireId, $langId) {
        return QuestionnaireLanguage::where(['questionnaire_id' => $questionnaireId, 'language_id' => $langId])->first();
    }

    public function getQuestionnaireTranslationsGroupedByLanguageAndQuestion($questionnaireId) {
        $questionnaireTranslations = DB::table('questionnaire_questions as qq')
            ->leftJoin('questionnaire_possible_answers as qpa', 'qq.id', '=', 'qpa.question_id')
            ->leftJoin('questionnaire_html as qh', 'qq.id', '=', 'qh.question_id')
            ->leftJoin('questionnaire_translation_questions as qtq', 'qq.id', '=', 'qtq.question_id')
            ->leftJoin('questionnaire_translation_html as qth', 'qh.id', '=', 'qth.html_id')
            ->leftJoin('questionnaire_languages as ql', function ($join) {
                $join->on('qtq.questionnaire_language_id', '=', 'ql.id')->orOn('qth.questionnaire_language_id', '=', 'ql.id');
            })
            ->leftJoin('questionnaire_translation_possible_answers as qta', function ($join) {
                $join->on('ql.id', '=', 'qta.questionnaire_language_id');
                $join->on('qpa.id', '=', 'qta.possible_answer_id');
            })
            ->leftJoin('languages_lkp as ll', 'ql.language_id', '=', 'll.id')
            ->where('qq.questionnaire_id', $questionnaireId)
            ->whereNull('qq.deleted_at')
            ->whereNull('qpa.deleted_at')
            ->whereNull('qh.deleted_at')
            ->whereNull('qtq.deleted_at')
            ->whereNull('ql.deleted_at')
            ->whereNull('qta.deleted_at')
            ->whereNull('qth.deleted_at')
            ->orderBy('ql.id')
            ->orderBy('qq.id')
            ->select('qq.id as question_id', 'qq.question', 'qq.name as question_name', 'qpa.id as answer_id',
                'qpa.answer', 'qpa.value as answer_value', 'qh.id as html_id',
                'qh.html', 'll.id as language_id', 'll.language_name', 'qtq.translation as translated_question',
                'qta.translation as translated_answer', 'qth.translation as translated_html')
            ->get();
        $temp = $questionnaireTranslations->groupBy('language_name');
        $result = collect([]);
        foreach ($temp as $key => $t) {
            $result->put($key, $t->groupBy('question_id'));
        }
        return $result;
    }

    public function getAvailableLanguagesForQuestionnaire($questionnaire) {
        $availableLanguages = [
            (object)[
                "language_code" => $questionnaire->defaultLanguage->language_code,
                "language_name" => $questionnaire->defaultLanguage->language_name,
                "default" => true,
                "machine_generated_translation" => 0 //default language is always created by the user, while designing the questionnaire
            ]
        ];
        $questionnaireLanguages = QuestionnaireLanguage::where('questionnaire_id', $questionnaire->id)->with('language')->get();
        foreach ($questionnaireLanguages as $ql) {
            array_push($availableLanguages,
                (object)["language_code" => $ql->language->language_code,
                    "language_name" => $ql->language->language_name,
                    "default" => false,
                    "machine_generated_translation" => $ql->machine_generated_translation]
            );
        }
        return collect($availableLanguages);
    }

    public function storeQuestionnaireTranslations($questionnaireId, $translations) {
        $questionnaireLanguages = $this->getQuestionnaireAvailableLanguages($questionnaireId);
        DB::transaction(function () use ($questionnaireId, $translations, $questionnaireLanguages) {
            $allTranslations = [];
            // convert stdClass created by json_decode to array
            $translations = get_object_vars($translations);
            foreach ($translations as $languageId => $languageWithTranslations) {
                $questionnaireLanguage = $questionnaireLanguages->where('language_id', $languageId)->first();
                $language = Language::findOrFail($languageId);
                $languageCode = $language->language_code;
                if (is_null($questionnaireLanguage)) {
                    $questionnaireLanguage = new QuestionnaireLanguage();
                    $questionnaireLanguage->questionnaire_id = $questionnaireId;
                    $questionnaireLanguage->language_id = $languageId;
                    $questionnaireLanguage->save();
                } else {
                    $this->removeTranslationsForQuestionnaireLanguage($questionnaireLanguage->id);
                }
                foreach ($languageWithTranslations as $translations) {
                    foreach ($translations as $translation) {
                        array_push($allTranslations, (object)[
                            'questionnaire_language_id' => $questionnaireLanguage->id,
                            'id' => $translation->id,
                            'type' => $translation->type,
                            'translation' => $translation->translation,
                            'name' => $translation->name,
                            'value' => isset($translation->value) ? $translation->value : null,
                            'language_code' => $languageCode
                        ]);
                    }
                }
            }
            $allTranslations = collect($allTranslations);
            $this->storeQuestionnaireJsonWithTranslations($questionnaireId, $allTranslations);
            $allTranslations = $allTranslations->groupBy('type');
            if ($allTranslations->has('question'))
                $this->storeAllQuestionsTranslations($allTranslations->get('question'));
            if ($allTranslations->has('answer'))
                $this->storeAllAnswersTranslations($allTranslations->get('answer'));
            if ($allTranslations->has('html'))
                $this->storeAllHtmlTranslations($allTranslations->get('html'));
        });
    }

    private function removeTranslationsForQuestionnaireLanguage($questionnaireLanguageId) {
        QuestionnaireTranslationQuestion::where("questionnaire_language_id", $questionnaireLanguageId)->delete();
        QuestionnaireTranslationPossibleAnswer::where("questionnaire_language_id", $questionnaireLanguageId)->delete();
        QuestionnaireTranslationHtml::where("questionnaire_language_id", $questionnaireLanguageId)->delete();
    }

    private function storeQuestionnaireJsonWithTranslations($questionnaireId, $allTranslations) {
        $questionnaire = Questionnaire::findOrFail($questionnaireId);
        $json = json_decode($questionnaire->questionnaire_json);
        $new_json = '{"pages": [';

        foreach ($json->pages as $page) {
            $elements = [];
            foreach ($page->elements as $question) {
                $relatedTranslations = $allTranslations->where('name', $question->name);
                $questionTranslations = $relatedTranslations->where('type', 'question');
                $question->title = $this->setQuestionnaireJsonTitleWithTranslations($questionTranslations, $question);
                if (isset($question->choices)) {
                    $answerTranslations = $relatedTranslations->where('type', 'answer');
                    $question->choices = $this->setQuestionnaireJsonChoicesWithTranslations($answerTranslations, $question);
                }
                if (isset($question->html)) {
                    $htmlTranslations = $relatedTranslations->where('type', 'html');
                    $question->html = $this->setQuestionnaireJsonHtmlWithTranslations($htmlTranslations, $question);
                }
                if (isset($question->hasOther)) {
                    $otherTranslations = $answerTranslations->where("value", "other");
                    $question->otherText = $this->setQuestionnaireJsonOtherWithTranslations($otherTranslations, $question);
                }
                array_push($elements, $question);
            }

            $new_json .= '{"name": "' . $page->name . '", "elements": ' . json_encode($elements) . '},';
        }

        $new_json = rtrim($new_json, ',');

        $questionnaire->questionnaire_json = $new_json . ']}';
        $questionnaire->save();
    }

    private function setQuestionnaireJsonTitleWithTranslations($questionTranslations, $element) {
        if (isset($element->title)) {
            if (isset($element->title->default)) // if title translations already exist
                $defaultTitle = $element->title->default;
            else
                $defaultTitle = $element->title;
        } else { // if title property does not exist in element
            $defaultTitle = $element->name;
        }
        $temp = $this->setAllTranslationsForAQuestionnaireString($defaultTitle, $questionTranslations);
        return (object)$temp;
    }

    private function setQuestionnaireJsonChoicesWithTranslations($answerTranslations, $element) {
        $choices = [];
        foreach ($element->choices as $choice) {
            if (isset($choice->text)) {
                if (isset($choice->text->default)) // if translations already exist
                    $defaultChoice = $choice->text->default;
                else
                    $defaultChoice = $choice->text;
            } else {
                $defaultChoice = $choice;
            }
            if (isset($choice->value))
                $choiceValue = $choice->value;
            else
                $choiceValue = $choice;
            $guid = $choice->guid;
            $answers = $answerTranslations->where('value', $choiceValue);
            $temp = ['value' => $choiceValue, 'text' => $this->setAllTranslationsForAQuestionnaireString($defaultChoice, $answers),
                'guid' => $guid
            ];
            array_push($choices, $temp);
        }
        return $choices;
    }

    private function setQuestionnaireJsonHtmlWithTranslations($htmlTranslations, $element) {
        $temp = $this->setAllTranslationsForAQuestionnaireString(
            (isset($element->html->default) ? $element->html->default : $element->html), $htmlTranslations);
        return (object)$temp;
    }

    private function setQuestionnaireJsonOtherWithTranslations($otherTranslations, $question) {
        $defaultValue = $this->getOtherAnswerTitle($question);
        $temp = $this->setAllTranslationsForAQuestionnaireString($defaultValue, $otherTranslations);
        return (object)$temp;
    }

    private function setAllTranslationsForAQuestionnaireString($defaultLanguageValue, $translations) {
        $temp = ['default' => $defaultLanguageValue];
        foreach ($translations as $translation) {
            $langCode = $translation->language_code;
            $temp[$langCode] = $translation->translation;
        }
        return $temp;
    }

    private function storeQuestionTranslation($translation) {
        $questionTranslation = new QuestionnaireTranslationQuestion();
        $questionTranslation->questionnaire_language_id = $translation->questionnaire_language_id;
        $questionTranslation->question_id = $translation->id;
        $questionTranslation->translation = $translation->translation;
        $questionTranslation->save();
        return $questionTranslation;
    }

    private function storeAllAnswersTranslations($translations) {
        foreach ($translations as $translation) {
            $this->storeAnswerTranslation($translation);
        }
    }

    private function storeAnswerTranslation($translation) {
        $answerTranslation = new QuestionnaireTranslationPossibleAnswer();
        $answerTranslation->questionnaire_language_id = $translation->questionnaire_language_id;
        $answerTranslation->possible_answer_id = $translation->id;
        $answerTranslation->translation = $translation->translation;
        $answerTranslation->save();
        return $answerTranslation;
    }

    private function storeAllHtmlTranslations($translations) {
        foreach ($translations as $translation) {
            $this->storeHtmlTranslation($translation);
        }
    }

    private function storeHtmlTranslation($translation) {
        $htmlTranslation = new QuestionnaireTranslationHtml();
        $htmlTranslation->questionnaire_language_id = $translation->questionnaire_language_id;
        $htmlTranslation->html_id = $translation->id;
        $htmlTranslation->translation = $translation->translation;
        $htmlTranslation->save();
        return $htmlTranslation;
    }

    private function storeAllQuestionsTranslations($translations) {
        foreach ($translations as $translation) {
            $this->storeQuestionTranslation($translation);
        }
    }

    public function getOtherAnswerTitle($question) {
        if (isset($question->otherText) && is_string($question->otherText))
            return $question->otherText;
        else if (isset($question->otherText) && isset($question->otherText->default))
            return $question->otherText->default;
        else
            return "Other (please describe)";

    }
}
