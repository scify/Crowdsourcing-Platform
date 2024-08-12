<?php

namespace App\Http\Controllers\Questionnaire;

use App\BusinessLogicLayer\questionnaire\QuestionnaireReportManager;
use App\Http\Controllers\Controller;
use App\Repository\Questionnaire\QuestionnaireRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuestionnaireReportController extends Controller {
    protected $questionnaireReportManager;
    protected $questionnaireRepository;

    public function __construct(QuestionnaireReportManager $questionnaireReportManager,
        QuestionnaireRepository $questionnaireRepository) {
        $this->questionnaireReportManager = $questionnaireReportManager;
        $this->questionnaireRepository = $questionnaireRepository;
    }

    public function viewReportsPage(Request $request) {
        $selectedQuestionnaireId = $request->questionnaireId;
        $viewModel = $this->questionnaireReportManager->getCrowdSourcingProjectReportsViewModel(null, $selectedQuestionnaireId);

        return view('questionnaire.reports.reports-with-filters', ['viewModel' => $viewModel]);
    }

    public function getReportDataForQuestionnaire(Request $request): JsonResponse {
        $input = $request->all();
        try {
            $questionnaire = $this->questionnaireRepository->find($input['questionnaireId']);
            $reportViewModel = $this->questionnaireReportManager->getQuestionnaireReportViewModel($input);
            $responses = $reportViewModel->responses;
            $view = view('questionnaire.reports.report-for-questionnaire', compact('reportViewModel'));
            $responseCode = Response::HTTP_OK;
            $responseContent = ['view' => $view->render(), 'questionnaire' => $questionnaire, 'responses' => $responses];
        } catch (QueryException $e) {
            $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $responseContent = 'Error: ' . $e->getCode() . '. A Database error occurred.';
        } catch (\Exception $e) {
            $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $responseContent = 'Error: ' . $e->getCode() . '  ' . $e->getMessage();
        } finally {
            return response()->json(['data' => $responseContent], $responseCode);
        }
    }
}
