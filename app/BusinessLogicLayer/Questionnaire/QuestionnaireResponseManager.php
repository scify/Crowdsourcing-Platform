<?php

namespace App\BusinessLogicLayer\Questionnaire;

use App\BusinessLogicLayer\LanguageManager;
use App\BusinessLogicLayer\User\UserManager;
use App\Jobs\TranslateQuestionnaireResponse;
use App\Models\User\User;
use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireAnswerVoteRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class QuestionnaireResponseManager {
    protected QuestionnaireRepository $questionnaireRepository;
    protected QuestionnaireResponseRepository $questionnaireResponseRepository;
    protected LanguageManager $languageManager;
    protected QuestionnaireActionHandler $questionnaireActionHandler;
    protected QuestionnaireAnswerVoteRepository $questionnaireAnswerVoteRepository;
    protected UserManager $userManager;

    public function __construct(QuestionnaireRepository $questionnaireRepository,
        QuestionnaireResponseRepository $questionnaireResponseRepository,
        LanguageManager $languageManager,
        QuestionnaireActionHandler $questionnaireActionHandler,
        QuestionnaireAnswerVoteRepository $questionnaireAnswerVoteRepository,
        UserManager $userManager) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->questionnaireResponseRepository = $questionnaireResponseRepository;
        $this->languageManager = $languageManager;
        $this->questionnaireActionHandler = $questionnaireActionHandler;
        $this->questionnaireAnswerVoteRepository = $questionnaireAnswerVoteRepository;
        $this->userManager = $userManager;
    }

    public function getQuestionnaireResponsesForUser(User $user) {
        return $this->questionnaireResponseRepository->getAllResponsesGivenByUser($user->id);
    }

    public function questionnaireResponsesForUserAndQuestionnaireExists($userId, $questionnaireId): bool {
        return $this->questionnaireResponseRepository->questionnaireResponseExists($userId, $questionnaireId);
    }

    public function getQuestionnaireResponsesForQuestionnaire(int $questionnaire_id, int $projectFilter): Collection {
        $queryFilters = ['questionnaire_id' => $questionnaire_id];
        // we only allow the responses to be filtered by project for logged in Answer Moderators
        if ($projectFilter > 0 && Gate::allows('moderate-content-by-users')) {
            $queryFilters['project_id'] = $projectFilter;
        }

        return $this->questionnaireResponseRepository->allWhere($queryFilters, ['*'], 'id', 'desc', ['project']);
    }

    public function transferQuestionnaireResponsesOfAnonymousUserToUser($user): int {
        $questionnaireResponsesThatWereTransferredToUser = $this->questionnaireResponseRepository->transferQuestionnaireResponsesOfAnonymousUserToUser($user->id);
        if ($questionnaireResponsesThatWereTransferredToUser) {
            foreach ($questionnaireResponsesThatWereTransferredToUser as $questionnaireResponse) {
                $lang = $this->languageManager->getLanguageById($questionnaireResponse->language_id);
                $this->questionnaireActionHandler->handleQuestionnaireContributor($questionnaireResponse->questionnaire, $questionnaireResponse->project,
                    $user, $lang);
                // if the user got invited by another user to answer the questionnaire, also award the referrer user.
                $this->questionnaireActionHandler->handleQuestionnaireReferrer($questionnaireResponse->questionnaire, $user,
                    $lang);
            }

            return count($questionnaireResponsesThatWereTransferredToUser);
        }

        return 0;
    }

    public function storeQuestionnaireResponse($data) {
        $user = $this->userManager->getLoggedInUserOrCreateAnonymousUser();
        $questionnaire = $this->questionnaireRepository->find($data['questionnaire_id']);
        // fix for greek language
        if (isset($data['language_code']) && $data['language_code'] == 'gr') {
            $data['language_code'] = 'el';
        }
        $language = isset($data['language_code'])
            ? $this->languageManager->getLanguageByCode($data['language_code'])
            : $this->languageManager->getLanguage($questionnaire->default_language_id);

        $queryData = [
            'questionnaire_id' => $data['questionnaire_id'],
            'user_id' => $user->id,
            'project_id' => $data['project_id'],
        ];
        $questionnaireResponse = $this->questionnaireResponseRepository->updateOrCreate(
            $queryData,
            array_merge($queryData, [
                'language_id' => $language->id,
                'response_json' => json_encode(json_decode($data['response'])),
                'browser_fingerprint_id' => $data['browser_fingerprint_id'],
                'browser_ip' => $data['ip'],
            ])
        );

        try {
            if (Auth::check()) {
                $this->questionnaireActionHandler->handleQuestionnaireContributor($questionnaire,
                    $questionnaireResponse->project,
                    $user,
                    $language);
                // if the user got invited by another user to answer the questionnaire, also award the referrer user.
                $this->questionnaireActionHandler->handleQuestionnaireReferrer($questionnaire, $user, $language);
            }
            TranslateQuestionnaireResponse::dispatch($questionnaireResponse->id);
        } catch (\Exception $e) {
            if (app()->bound('sentry')) {
                app('sentry')->captureException($e);
            } else {
                Log::error($e->getMessage());
            }
        }

        return $questionnaireResponse;
    }

    public function storeQuestionnaireResponseForModerator($data) {
        $user = Auth::user();
        $questionnaire = $this->questionnaireRepository->find($data['questionnaire_id']);
        // fix for greek language
        if (isset($data['language_code']) && $data['language_code'] == 'gr') {
            $data['language_code'] = 'el';
        }
        $language = isset($data['language_code'])
            ? $this->languageManager->getLanguageByCode($data['language_code'])
            : $this->languageManager->getLanguage($questionnaire->default_language_id);

        $queryData = [
            'questionnaire_id' => $data['questionnaire_id'],
            'user_id' => $user->id,
            'project_id' => $data['project_id'],
        ];

        return $this->questionnaireResponseRepository->create(
            array_merge($queryData, [
                'language_id' => $language->id,
                'response_json' => json_encode(json_decode($data['response'])),
                'browser_fingerprint_id' => $data['browser_fingerprint_id'],
                'browser_ip' => $data['ip'],
            ])
        );
    }

    public function getFreeTypeQuestionsFromQuestionnaireJSON(string $questionnaireJSON): array {
        $freeTypeQuestions = [];
        $freeTypeQuestionTypes = ['text', 'comment'];
        $questionnaire = json_decode($questionnaireJSON);
        $pages = $questionnaire->pages;
        foreach ($pages as $page) {
            foreach ($page->elements as $question) {
                if (in_array($question->type, $freeTypeQuestionTypes)) {
                    $freeTypeQuestions[$question->name] = $question;
                }
            }
        }

        return $freeTypeQuestions;
    }

    public function getAnswerVotesForQuestionnaireAnswers(int $questionnaire_id): Collection {
        return $this->questionnaireAnswerVoteRepository
            ->getAnswerVotesForQuestionnaireAnswers($questionnaire_id);
    }

    public function voteAnswer(int $questionnaire_id,
        string $question_name,
        int $respondent_user_id,
        int $voter_user_id,
        bool $upvote) {
        $data = [
            'questionnaire_id' => $questionnaire_id,
            'question_name' => $question_name,
            'respondent_user_id' => $respondent_user_id,
            'voter_user_id' => $voter_user_id,
        ];
        $existing = $this->questionnaireAnswerVoteRepository->where($data);
        if ($existing && $existing->upvote == $upvote) {
            return $existing->delete();
        } else {
            return $this->questionnaireAnswerVoteRepository->updateOrCreate($data, array_merge($data, ['upvote' => $upvote]));
        }
    }

    public function deleteResponse(int $questionnaire_response_id) {
        return $this->questionnaireResponseRepository->delete($questionnaire_response_id);
    }

    public function getAnswersWithVotesAndVoterInfoForQuestionnaire(int $questionnaire_id): Collection {
        $questionnaire = $this->questionnaireRepository->find($questionnaire_id);
        $answerVotesWithVoterInfoForQuestionnaire = $this->questionnaireAnswerVoteRepository->getAnswerVotesWithVoterInfoForQuestionnaire($questionnaire_id);
        $freeTypeQuestions = $this->getFreeTypeQuestionsFromQuestionnaireJSON($questionnaire->questionnaire_json);
        $data = new Collection;
        foreach ($answerVotesWithVoterInfoForQuestionnaire as $record) {
            $response = [];
            $response['response_id'] = $record->response_id;
            $response['voters'] = $record->voters;
            $response['num_votes'] = $record->votes;
            $response['question'] = $freeTypeQuestions[$record->question_name]->title;
            $response_json = json_decode($record->response_json);
            $response_json_translated = json_decode($record->response_json_translated);
            $response['answer'] = $response_json_translated->{$record->question_name} ?? $response_json->{$record->question_name};
            $data->add($response);
        }

        return $data;
    }

    public function getAnonymousUserResponseForQuestionnaire(int $questionnaire_id, string $ip, string $browser_fingerprint_id) {
        return $this->questionnaireResponseRepository->getResponseByAnonymousData($questionnaire_id, $ip, $browser_fingerprint_id);
    }
}
