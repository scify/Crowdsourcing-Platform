<?php

declare(strict_types=1);

namespace App\Http\Controllers\Questionnaire;

use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectManager;
use App\BusinessLogicLayer\Gamification\PlatformWideGamificationBadgesProvider;
use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\BusinessLogicLayer\lkp\QuestionnaireStatusLkp;
use App\BusinessLogicLayer\Questionnaire\QuestionnaireResponseManager;
use App\BusinessLogicLayer\User\UserManager;
use App\Http\Controllers\Controller;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Questionnaire\Questionnaire;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use App\ViewModels\Gamification\GamificationBadgeVM;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpFoundation\StreamedResponse;

class QuestionnaireResponseController extends Controller {
    public function __construct(protected QuestionnaireResponseManager $questionnaireResponseManager, protected PlatformWideGamificationBadgesProvider $platformWideGamificationBadgesProvider, protected QuestionnaireResponseRepository $questionnaireResponseRepository, protected CrowdSourcingProjectManager $crowdSourcingProjectManager) {}

    public function store(Request $request): JsonResponse {
        $this->validate($request, [
            'browser_fingerprint_id' => 'required|string',
            'questionnaire_id' => 'required|integer|exists:questionnaires,id',
            'project_id' => 'required|integer|exists:crowd_sourcing_projects,id',
            'response' => 'required|json',
        ]);
        $isModeratorResponse = $request->boolean('moderator');
        $this->authorizeResponseSubmission(
            Questionnaire::findOrFail($request->integer('questionnaire_id')),
            CrowdSourcingProject::findOrFail($request->integer('project_id')),
            $isModeratorResponse
        );
        app()->setLocale($request->lang);
        $data = $request->all();
        $data['ip'] = $request->getClientIp();
        if ($isModeratorResponse) {
            $questionnaireResponse = $this->questionnaireResponseManager->storeQuestionnaireResponseForModerator($data);
        } else {
            $questionnaireResponse = $this->questionnaireResponseManager->storeQuestionnaireResponse($data);
        }

        $jsonResponse = response()->json([
            'anonymousUserId' => Auth::check() ? null : $questionnaireResponse->user_id,
            'responseId' => $questionnaireResponse->id,
        ]);
        if (! Auth::check()) {
            $jsonResponse->withCookie(Cookie::forever(UserManager::$USER_COOKIE_KEY, $questionnaireResponse->user_id));
        }

        return $jsonResponse;
    }

    /**
     * Applies the same rules as the questionnaire pages: the questionnaire must belong to the project,
     * and only content managers may respond to a questionnaire or project that is not published.
     * Moderator responses need the moderator permission and use the moderator page rules.
     */
    private function authorizeResponseSubmission(Questionnaire $questionnaire, CrowdSourcingProject $project, bool $isModeratorResponse): void {
        abort_unless($questionnaire->projects->contains($project), ResponseAlias::HTTP_FORBIDDEN, 'The questionnaire does not belong to the project.');

        if ($isModeratorResponse) {
            abort_unless(Gate::allows('moderate-content-by-users'), ResponseAlias::HTTP_FORBIDDEN);

            return;
        }

        if (Gate::allows('create-platform-content')) {
            return;
        }

        abort_unless($questionnaire->status_id === QuestionnaireStatusLkp::PUBLISHED, ResponseAlias::HTTP_FORBIDDEN, 'The questionnaire is not active.');
        abort_unless($project->status_id === CrowdSourcingProjectStatusLkp::PUBLISHED, ResponseAlias::HTTP_FORBIDDEN, 'The project is not active.');
    }

    public function getResponsesForQuestionnaire(Questionnaire $questionnaire, int $projectFilter = -1): JsonResponse {
        return response()->json($this->questionnaireResponseManager->getQuestionnaireResponsesForQuestionnaire($questionnaire->id, $projectFilter));
    }

    public function getAnswerVotesForQuestionnaireAnswers(Questionnaire $questionnaire): JsonResponse {
        return response()->json($this->questionnaireResponseManager
            ->getAnswerVotesForQuestionnaireAnswers($questionnaire->id));
    }

    public function voteAnswer(Request $request): JsonResponse {
        $this->validate($request, [
            'questionnaire_id' => 'required|integer|exists:questionnaires,id',
            'question_name' => 'required|string|max:255',
            'respondent_user_id' => 'required|integer',
            'upvote' => 'required|boolean',
        ]);

        // The voter is always the logged-in user. A voter_user_id in the request is ignored.
        return response()->json($this->questionnaireResponseManager
            ->voteAnswer(
                intval($request->questionnaire_id),
                $request->question_name,
                intval($request->respondent_user_id),
                intval(Auth::id()),
                $request->boolean('upvote'))
        );
    }

    public function destroy(Request $request) {
        $this->validate($request, [
            'questionnaire_response_id' => 'required|integer|exists:questionnaire_responses,id',
        ]);

        return $this->questionnaireResponseManager->deleteResponse(intval($request->questionnaire_response_id));
    }

    public function downloadQuestionnaireResponses(int $questionnaire_id): StreamedResponse {
        $data = $this->questionnaireResponseManager->getAnswersWithVotesAndVoterInfoForQuestionnaire($questionnaire_id);
        $fileName = 'questionnaire_text_responses_' . $questionnaire_id . '.csv';

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=' . $fileName,
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
                $userId = intval(Auth::id());
            } else {
                $userId = intval($request->anonymous_user_id);
            }

            $is_moderator_view = $request->is_moderator_view ?? false;
            $response = $this->questionnaireResponseRepository->where(['id' => $request->response_id, 'user_id' => $userId]);
            if (! $response) {
                abort(ResponseAlias::HTTP_NOT_FOUND);
            }

            $project = $this->crowdSourcingProjectManager->getCrowdSourcingProject($response->project_id);
            $viewModel = $this->crowdSourcingProjectManager->getCrowdSourcingProjectViewModelForThankYouPage(intval($request->questionnaire_id), $project->slug, $is_moderator_view);
            $viewModel->response_id = $response->id;
            $questionnaireIdsUserHasAnsweredTo = $this->questionnaireResponseRepository
                ->allWhere(['user_id' => $response->user_id])->pluck('questionnaire_id')->toArray();
            $gamificationBadgeVM = new GamificationBadgeVM($this->platformWideGamificationBadgesProvider->getContributorBadge($userId, count($questionnaireIdsUserHasAnsweredTo)));

            return view('questionnaire.thanks_for_responding')->with(['viewModel' => $viewModel, 'badge' => $gamificationBadgeVM]);
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
                intval($request->questionnaire_id),
                $request->browser_fingerprint_id),
        ]);
    }
}
