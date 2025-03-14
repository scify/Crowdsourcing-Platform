<?php

namespace App\Http\Controllers\Questionnaire;

use App\BusinessLogicLayer\Questionnaire\QuestionnaireReportManager;
use App\Http\Controllers\Controller;
use App\Repository\Questionnaire\QuestionnaireRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class QuestionnaireReportController extends Controller {
    public function __construct(protected QuestionnaireReportManager $questionnaireReportManager, protected QuestionnaireRepository $questionnaireRepository) {}

    public function viewReportsPage(Request $request) {
        $selectedQuestionnaireId = $request->questionnaireId;
        $viewModel = $this->questionnaireReportManager->getCrowdSourcingProjectReportsViewModel(null, $selectedQuestionnaireId);

        return view('backoffice.questionnaire.reports.reports-with-filters', ['viewModel' => $viewModel]);
    }

    public function getReportDataForQuestionnaire(Request $request): JsonResponse {
        $input = $request->all();
        try {
            $questionnaire = $this->questionnaireRepository->find($input['questionnaireId'], ['*']);
            $questionnaireJson = json_decode($questionnaire->questionnaire_json, true);

            $newQuestion = [
                'type' => 'text',
                'name' => 'campaign_name',
                'title' => [
                    'default' => 'Campaign',
                ],
            ];

            $questionnaireJson['pages'][0]['elements'][] = $newQuestion;
            $questionnaire->questionnaire_json = json_encode($questionnaireJson);

            $reportViewModel = $this->questionnaireReportManager->getQuestionnaireReportViewModel($input);
            $responses = $reportViewModel->responses;
            $view = view('backoffice.questionnaire.reports.report-for-questionnaire', ['reportViewModel' => $reportViewModel]);
            $responseCode = ResponseAlias::HTTP_OK;
            $responseContent = ['view' => $view->render(), 'questionnaire' => $questionnaire, 'responses' => $responses];
        } catch (QueryException $e) {
            \Log::error($e->getMessage());
            $responseCode = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR;
            $responseContent = 'Error: ' . $e->getCode() . '. A Database error occurred.';
        } catch (\Exception $e) {
            $responseCode = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR;
            $responseContent = 'Error: ' . $e->getCode() . '  ' . $e->getMessage();
        } finally {
            return response()->json(['data' => $responseContent], $responseCode);
        }
    }
}
