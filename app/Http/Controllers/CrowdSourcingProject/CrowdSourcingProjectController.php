<?php

declare(strict_types=1);

namespace App\Http\Controllers\CrowdSourcingProject;

use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectManager;
use App\BusinessLogicLayer\User\UserQuestionnaireShareManager;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CrowdSourcingProjectController extends Controller {
    public function __construct(private readonly CrowdSourcingProjectManager $crowdSourcingProjectManager, private readonly UserQuestionnaireShareManager $questionnaireShareManager) {}

    public function index(): View|Factory {
        $viewModel = $this->crowdSourcingProjectManager->getCrowdSourcingProjectsListPageViewModel();

        return view('backoffice.management.crowdsourcing-project.index', ['viewModel' => $viewModel]);
    }

    public function create() {
        return view('backoffice.management.crowdsourcing-project.create-edit.form-page')->with(['viewModel' => $this->crowdSourcingProjectManager->getCreateEditProjectViewModel()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $locale, int $id): View {
        return view('backoffice.management.crowdsourcing-project.create-edit.form-page')->with(['viewModel' => $this->crowdSourcingProjectManager->getCreateEditProjectViewModel($id)]);
    }

    /**
     * Create and store the specified resource in storage.
     *
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'status_id' => 'required|numeric|exists:crowd_sourcing_project_statuses_lkp,id',
            'slug' => 'nullable|string|alpha_dash|unique:crowd_sourcing_projects,slug|max:100',
            'language_id' => 'required|numeric|exists:languages_lkp,id',
            'motto_title' => 'required|string',
            'motto_subtitle' => 'required|string',
            'about' => 'nullable|string',
        ]);
        $project = $this->crowdSourcingProjectManager->storeProject($request->all());

        return redirect()->route('projects.edit', $project->id)->with('flash_message_success', 'The project has been successfully created');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id  the project id
     *
     * @throws ValidationException
     */
    public function update(Request $request, string $locale, int $id): RedirectResponse {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'status_id' => 'required|numeric|exists:crowd_sourcing_project_statuses_lkp,id',
            'description' => 'required|string',
            'slug' => 'nullable|string|alpha_dash|unique:crowd_sourcing_projects,slug,' . $id . '|max:100',
            'language_id' => 'required|numeric|exists:languages_lkp,id',
            'motto_title' => 'required|string',
            'motto_subtitle' => 'required|string',
            'about' => 'nullable|string',
        ]);
        $attributes = $request->all();
        try {
            $this->crowdSourcingProjectManager->updateProject($id, $attributes);
        } catch (\Exception $exception) {
            return back()->with('flash_message_error', $exception->getMessage());
        }

        return back()->with('flash_message_success', 'The project has been successfully updated');
    }

    public function showLandingPage(Request $request) {
        $data = [
            'project_slug' => $request->slug,
        ];
        $validator = Validator::make($data, [
            'project_slug' => 'required|different:execute_solution|exists:crowd_sourcing_projects,slug',
        ]);
        if ($validator->fails()) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }

        try {
            $project_slug = $request->slug;
            if (Gate::allows('view-landing-page', $project_slug)) {
                return $this->showCrowdSourcingProjectLandingPage($request, $project_slug);
            }

            return view('crowdsourcing-project.project-unavailable')
                ->with(['viewModel' => $this->crowdSourcingProjectManager->
                getUnavailableCrowdSourcingProjectViewModelForLandingPage($project_slug), ]);
        } catch (ModelNotFoundException) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    protected function showCrowdSourcingProjectLandingPage(Request $request, string $project_slug) {
        try {
            $viewModel = $this->crowdSourcingProjectManager->getCrowdSourcingProjectViewModelForLandingPage(
                intval($request->questionnaireId) ?? 0,
                $project_slug);

            if ($this->shouldHandleQuestionnaireShare($request)) {
                $this->questionnaireShareManager->handleQuestionnaireShare($request->all(), $request->referrerId);
            }

            return view('crowdsourcing-project.landing-page')->with(['viewModel' => $viewModel]);
        } catch (\Exception $exception) {
            session()->flash('flash_message_error', 'Error: ' . $exception->getCode() . '  ' . $exception->getMessage());

            return redirect()->to(route('home', ['locale' => app()->getLocale()]));
        }
    }

    private function shouldHandleQuestionnaireShare(\Illuminate\Http\Request $request): bool {
        return
            property_exists($request, 'questionnaireId') && $request->questionnaireId !== null &&
            (property_exists($request, 'referrerId') && $request->referrerId !== null);
    }

    public function clone(Request $request): RedirectResponse {
        $newProject = $this->crowdSourcingProjectManager->cloneProject(intval($request->id));

        return redirect()->action(
            [self::class, 'edit'], ['project' => $newProject->id]
        );
    }

    public function getCrowdSourcingProjectsForManagement(): JsonResponse {
        return response()->json($this->crowdSourcingProjectManager->getCrowdSourcingProjectsForManagement());
    }

    public function downloadUserEngagementReport(string $locale, int $id) {
        $engagementData = $this->crowdSourcingProjectManager->getUserEngagementDataForProject($id);
        $fileName = 'user_engagement_report_project_' . $id . '_' . date('Y-m-d') . '.xlsx';

        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $headers = [
            'Name/Nickname',
            'Email/IP',
            'Gender',
            'Country',
            'Phase 1: Questionnaire answers',
            'Phase 1 date',
            'Phase 2: Solution proposed',
            'Phase 3: Votes',
            'Phase 3: Votes date',
        ];

        // Add headers to the first row
        $sheet->fromArray($headers, null, 'A1');

        // Style the header row
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->getStyle('A1:I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1:I1')->getFill()->getStartColor()->setARGB('FFCCCCCC');

        // Add data rows
        $rowNumber = 2;
        foreach ($engagementData as $record) {
            $sheet->fromArray([
                $record['name_nickname'],
                $record['email_ip'],
                $record['gender'],
                $record['country'],
                $record['phase1_questionnaire'],
                $record['phase1_date'],
                $record['phase2_solution'],
                $record['phase3_votes'],
                $record['phase3_date'],
            ], null, 'A' . $rowNumber);
            ++$rowNumber;
        }

        // Auto-size columns
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Create writer and save to output
        $writer = new Xlsx($spreadsheet);

        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($writer): void {
            $writer->save('php://output');
        };

        return response()->stream($callback, ResponseAlias::HTTP_OK, $headers);
    }
}
