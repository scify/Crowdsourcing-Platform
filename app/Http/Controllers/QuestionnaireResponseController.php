<?php


namespace App\Http\Controllers;


use App\BusinessLogicLayer\gamification\PlatformWideGamificationBadgesProvider;
use App\BusinessLogicLayer\questionnaire\QuestionnaireResponseManager;
use App\BusinessLogicLayer\UserManager;
use App\Models\ViewModels\GamificationBadgeVM;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpFoundation\StreamedResponse;

class QuestionnaireResponseController extends Controller {

    protected $questionnaireResponseManager;
    protected $platformWideGamificationBadgesProvider;
    protected $questionnaireResponseRepository;

    public function __construct(QuestionnaireResponseManager           $questionnaireResponseManager,
                                PlatformWideGamificationBadgesProvider $platformWideGamificationBadgesProvider,
                                QuestionnaireResponseRepository        $questionnaireResponseRepository) {
        $this->questionnaireResponseManager = $questionnaireResponseManager;
        $this->platformWideGamificationBadgesProvider = $platformWideGamificationBadgesProvider;
        $this->questionnaireResponseRepository = $questionnaireResponseRepository;
    }

    public function store(Request $request): JsonResponse {
        app()->setLocale($request->lang);
        $questionnaireResponse = $this->questionnaireResponseManager->storeQuestionnaireResponse($request->all());
        $questionnaireIdsUserHasAnsweredTo = $this->questionnaireResponseRepository
            ->allWhere(['user_id' => $questionnaireResponse->user_id])->pluck('questionnaire_id')->toArray();
        $badge = new GamificationBadgeVM($this->platformWideGamificationBadgesProvider->getContributorBadge($questionnaireIdsUserHasAnsweredTo));
        $response = response()->json([
            'badgeHTML' => (string)view('gamification.badge-single', compact('badge')),
            'anonymousUserId' => Auth::check() ? null : $questionnaireResponse->user_id
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
            'questionnaire_response_id' => 'required|integer|exists:questionnaire_responses,id'
        ]);
        return $this->questionnaireResponseManager->deleteResponse($request->questionnaire_response_id);
    }

    public function downloadQuestionnaireResponses(int $questionnaire_id): StreamedResponse {
        $data = $this->questionnaireResponseManager->getAnswersWithVotesAndVoterInfoForQuestionnaire($questionnaire_id);
        $fileName = 'questionnaire_text_responses_' . $questionnaire_id . '.csv';

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array('Id', 'Question', 'Answer', 'Number of votes', 'Voters');

        $callback = function () use ($data, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($data as $record) {
                $row['Id'] = $record['response_id'];
                $row['Question'] = $record['question'];
                $row['Answer'] = $record['answer'];
                $row['Number of votes'] = $record['num_votes'];
                $row['Voters'] = $record['voters'];

                fputcsv($file, array($row['Id'], $row['Question'], $row['Answer'], $row['Number of votes'], $row['Voters']));
            }
            fclose($file);
        };

        return response()->stream($callback, ResponseAlias::HTTP_OK, $headers);
    }
}
