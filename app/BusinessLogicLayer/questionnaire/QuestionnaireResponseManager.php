<?php

namespace App\BusinessLogicLayer\questionnaire;


use App\BusinessLogicLayer\LanguageManager;
use App\Models\Questionnaire;
use App\Models\QuestionnaireResponse;
use App\Models\User;
use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseAnswerTextRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class QuestionnaireResponseManager {

    protected $questionnaireRepository;
    protected $questionnaireResponseRepository;
    protected $questionnaireResponseAnswerTextRepository;
    protected $languageManager;
    protected $questionnaireActionHandler;

    public function __construct(QuestionnaireRepository $questionnaireRepository,
                                QuestionnaireResponseRepository $questionnaireResponseRepository,
                                QuestionnaireResponseAnswerTextRepository $questionnaireResponseAnswerTextRepository,
                                LanguageManager $languageManager,
                                QuestionnaireActionHandler $questionnaireActionHandler) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->questionnaireResponseRepository = $questionnaireResponseRepository;
        $this->questionnaireResponseAnswerTextRepository = $questionnaireResponseAnswerTextRepository;
        $this->languageManager = $languageManager;
        $this->questionnaireActionHandler = $questionnaireActionHandler;
    }

    public function getQuestionnaireResponsesForUser(User $user) {
        return $this->questionnaireRepository->getAllResponsesGivenByUser($user->id);
    }

    public function questionnaireResponsesForUserExists($userId): bool {
        return $this->questionnaireResponseRepository->userResponseExists($userId);
    }

    public function questionnaireResponsesForUserAndQuestionnaireExists($userId, $questionnaireId): bool {
        return $this->questionnaireResponseRepository->questionnaireResponseExists($userId, $questionnaireId);
    }

    public function getQuestionnaireResponsesForQuestionnaire(int $questionnaire_id): Collection {
        return $this->questionnaireResponseRepository->allWhere(['questionnaire_id' => $questionnaire_id]);
    }

    public function storeQuestionnaireResponse($data) {
        $user = Auth::user();
        $questionnaire = $this->questionnaireRepository->find($data['questionnaire_id']);
        if (isset($data['language_code']))
            $language = $this->languageManager->getLanguageByCode($data['language_code']);
        else
            $language = $this->languageManager->getLanguage($questionnaire->default_language_id);

        $questionnaireResponse = $this->questionnaireResponseRepository->storeQuestionnaireResponse(
            $data['questionnaire_id'],
            $user->id,
            $language->id,
            $data['response']
        );
        $this->storeQuestionnaireAnswerTextsForInputTypeQuestions($questionnaire, $questionnaireResponse);
        $this->questionnaireActionHandler->handleQuestionnaireContributor($questionnaire, $user);
        // if the user got invited by another user to answer the questionnaire, also award the referrer user.
        $this->questionnaireActionHandler->handleQuestionnaireReferrer($questionnaire, $user);
    }

    protected function storeQuestionnaireAnswerTextsForInputTypeQuestions(Questionnaire $questionnaire,
                                                                          QuestionnaireResponse $questionnaireResponse) {
        $freeTypeQuestions = $this->getFreeTypeQuestionsFromQuestionnaireJSON($questionnaire->questionnaire_json);
        $answers = json_decode($questionnaireResponse->response_json);
        foreach ($answers as $questionName => $answer) {
            $shouldSave = false;
            if (isset($freeTypeQuestions[$questionName])) {
                $shouldSave = true;
            } else if (strpos($questionName, '-Comment') !== false) {
                $shouldSave = true;
                $questionName = str_replace('-Comment', '', $questionName);
            }
            if ($shouldSave) {
                $data = [
                    'questionnaire_id' => $questionnaire->id,
                    'questionnaire_response_id' => $questionnaireResponse->id,
                    'question_name' => $questionName
                ];
                $this->questionnaireResponseAnswerTextRepository->updateOrCreate(
                    $data,
                    array_merge($data, ['answer' => $answer])
                );
            }
        }

    }

    public function getFreeTypeQuestionsFromQuestionnaireJSON(string $questionnaireJSON): array {
        $freeTypeQuestions = [];
        $freeTypeQuestionTypes = ['text'];
        $questionnaire = json_decode($questionnaireJSON);
        $pages = $questionnaire->pages;
        foreach ($pages as $page)
            foreach ($page->elements as $question)
                if (in_array($question->type, $freeTypeQuestionTypes))
                    $freeTypeQuestions[$question->name] = $question;

        return $freeTypeQuestions;
    }

}
