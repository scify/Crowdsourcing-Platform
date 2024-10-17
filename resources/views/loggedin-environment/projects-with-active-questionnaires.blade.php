@if($viewModel->questionnaires->isEmpty())
    <p class="no-projects-found">{{ __("questionnaire.no_active_projects")}}</p>
@else
    @foreach($viewModel->questionnaires as $questionnaire)
        <div class="container-fluid questionnaire-section py-5 my-5" id="questionnaire-section-{{$questionnaire->id}}">
            <div class="row">
                <div class="col-12">
                    <h6 class="text-center">{{ $questionnaire->fieldsTranslation->title }}</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    @include('gamification.next-step', ['nextStepVM' => $questionnaire->gamificationNextStepVM, 'questionnaire' => $questionnaire])
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    @if ($questionnaire->type_id==1)
                        <div class="progress-container my-0">
                            @include('crowdsourcing-project.partials.project-goal',
                            ['questionnaireId' => $questionnaire->id, 'questionnaireViewModel' => $questionnaire->goalVM, 'project' => $questionnaire->projects->get(0)])
                            @if ($questionnaire->userHasAccessToViewStatisticsPage)
                                <div class="row">
                                    <div class="col">
                                        <a class="btn btn-primary btn-sm btn-statistics" target="_blank"
                                           href="{{ route('questionnaire.statistics', $questionnaire) }}">
                                            <i class="fas fa-chart-pie mr-2"></i> {{ __("my-dashboard.view_statistics")}}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
@endif