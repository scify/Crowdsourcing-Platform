<?php

namespace App\Http\Controllers\Questionnaire;

use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectManager;
use App\BusinessLogicLayer\Gamification\PlatformWideGamificationBadgesProvider;
use App\BusinessLogicLayer\Questionnaire\QuestionnaireResponseManager;
use App\BusinessLogicLayer\User\UserManager;
use App\Http\Controllers\Controller;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use App\ViewModels\Gamification\GamificationBadgeVM;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpFoundation\StreamedResponse;

class QuestionnaireResponseController extends Controller {
    public function __construct(protected QuestionnaireResponseManager $questionnaireResponseManager, protected PlatformWideGamificationBadgesProvider $platformWideGamificationBadgesProvider, protected QuestionnaireResponseRepository $questionnaireResponseRepository, protected CrowdSourcingProjectManager $crowdSourcingProjectManager) {}

    public function store(Request $request): JsonResponse {
        $this->validate($request, [
            'browser_fingerprint_id' => 'required|string',
            'questionnaire_id' => 'required|integer',
            'project_id' => 'required|integer',
            'response' => 'required|json',
        ]);
        app()->setLocale($request->lang);
        $data = $request->all();
        $data['ip'] = $request->getClientIp();
        if ($data['moderator']) {
            $questionnaireResponse = $this->questionnaireResponseManager->storeQuestionnaireResponseForModerator($data);
        } else {
            $questionnaireResponse = $this->questionnaireResponseManager->storeQuestionnaireResponse($data);
        }
        $response = response()->json([
            'anonymousUserId' => Auth::check() ? null : $questionnaireResponse->user_id,
            'responseId' => $questionnaireResponse->id,
        ]);
        if (!Auth::check()) {
            $response->withCookie(Cookie::forever(UserManager::$USER_COOKIE_KEY, $questionnaireResponse->user_id));
        }

        return $response;
    }

    public function getResponsesForQuestionnaire(int $questionnaire_id, int $projectFilter = -1): JsonResponse {
        return response()->json($this->questionnaireResponseManager->getQuestionnaireResponsesForQuestionnaire($questionnaire_id, $projectFilter));
    }

    public function getAnswerVotesForQuestionnaireAnswers(int $questionnaire_id): JsonResponse {
        return response()->json($this->questionnaireResponseManager
            ->getAnswerVotesForQuestionnaireAnswers($questionnaire_id));
    }

    public function voteAnswer(Request $request): JsonResponse {
        return response()->json($this->questionnaireResponseManager
            ->voteAnswer(
                $request->questionnaire_id,
                $request->question_name,
                $request->respondent_user_id,
                $request->voter_user_id,
                $request->upvote)
        );
    }

    public function destroy(Request $request) {
        $this->validate($request, [
            'questionnaire_response_id' => 'required|integer|exists:questionnaire_responses,id',
        ]);

        return $this->questionnaireResponseManager->deleteResponse($request->questionnaire_response_id);
    }

    public function downloadQuestionnaireResponses(int $questionnaire_id): StreamedResponse {
        $data = $this->questionnaireResponseManager->getAnswersWithVotesAndVoterInfoForQuestionnaire($questionnaire_id);
        $fileName = 'questionnaire_text_responses_' . $questionnaire_id . '.csv';

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columns = ['Id', 'Question', 'Answer', 'Number of votes', 'Voters'];

        $callback = function () use ($data, $columns): void {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($data as $record) {
                $row['Id'] = $record['response_id'];
                $row['Question'] = is_string($record['question']) ? $record['question'] : $record['question']->default;
                $row['Answer'] = is_string($record['answer']) ? $record['answer'] : 'Initial answer: ' . $record['answer']->initial_answer . "\n" . 'Translated: ' . $record['answer']->translated_answer;
                $row['Number of votes'] = $record['num_votes'];
                $row['Voters'] = $record['voters'];

                fputcsv($file, [$row['Id'], $row['Question'], $row['Answer'], $row['Number of votes'], $row['Voters']]);
            }
            fclose($file);
        };

        return response()->stream($callback, ResponseAlias::HTTP_OK, $headers);
    }

    public function showQuestionnaireThanksForRespondingPage(Request $request) {
        $data = [
            'questionnaire_id' => $request->questionnaire_id,
        ];
        $validator = Validator::make($data, [
            'questionnaire_id' => 'required|different:execute_solution|exists:questionnaires,id',
            'anonymous_user_id' => 'exists:users,id',
        ]);
        if ($validator->fails()) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
        try {
            if (Auth::check()) {
                $userId = Auth::id();
            } else {
                $userId = $request->anonymous_user_id;
            }
            $is_moderator_view = $request->is_moderator_view ?? false;
            $response = $this->questionnaireResponseRepository->where(['id' => $request->response_id, 'user_id' => $userId]);
            if (!$response) {
                abort(ResponseAlias::HTTP_NOT_FOUND);
            }
            $project = $this->crowdSourcingProjectManager->getCrowdSourcingProject($response->project_id);
            $viewModel = $this->crowdSourcingProjectManager->getCrowdSourcingProjectViewModelForThankYouPage($request->questionnaire_id, $project->slug, $is_moderator_view);
            $viewModel->response_id = $response->id;
            $questionnaireIdsUserHasAnsweredTo = $this->questionnaireResponseRepository
                ->allWhere(['user_id' => $response->user_id])->pluck('questionnaire_id')->toArray();
            $badge = new GamificationBadgeVM($this->platformWideGamificationBadgesProvider->getContributorBadge($userId, count($questionnaireIdsUserHasAnsweredTo)));

            return view('questionnaire.thanks_for_responding')->with(['viewModel' => $viewModel, 'badge' => $badge]);
        } catch (Exception) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    public function getAnonymousUserResponseForQuestionnaire(Request $request): JsonResponse {
        $this->validate($request, [
            'browser_fingerprint_id' => [
                'required',
                'string',
                'min:12',
                'max:128',
                'regex:/^[a-zA-Z0-9\-_]+$/',
            ],
            'questionnaire_id' => 'required|integer',
        ]);

        return response()->json([
            'questionnaire_response' => $this->questionnaireResponseManager->getAnonymousUserResponseForQuestionnaire(
                $request->questionnaire_id,
                $request->browser_fingerprint_id),
        ]);
    }
}
