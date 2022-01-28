<div id="questionnaire-wrapper">
    <div class="container">
        <div id="questionnaire"
             class="align-items-center mx-0"
             style="background-image: url('{{ asset($viewModel->project->lp_questionnaire_img_path) }}')">
            @if ($viewModel->questionnaire)
                <div class="text-center content-container"
                     style="background: {{ $viewModel->project->lp_primary_color }}D9">
                    <h3 class="questionnaire-section-title">
                        {{ $viewModel->userResponse? __("questionnaire.already_participated"):   $viewModel->questionnaire->fieldsTranslation->title }}
                    </h3>
                    @if(!$viewModel->userResponse)
                        <div class="questionnaire-description mb-5">
                            {!! $viewModel->questionnaire->fieldsTranslation->description !!}
                        </div>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6 col-sm-11 mx-auto">
                                    @include("landingpages.partials.open-questionnaire-button",["label"=>__("questionnaire.start_answering")])
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <div class="text-center content-container">
                    <div>
                        @if ($viewModel->project->status_id == App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp::FINALIZED)
                            <h3 class="questionnaire-section-title">{{ __("questionnaire.project_finalized") }}</h3>
                        @else
                            <h3 class="questionnaire-section-title">{{ __("questionnaire.no_active_questionnaires") }}</h3>
                            <h3 class="questionnaire-section-title">{{ __("questionnaire.next_questionnaire") }}</h3>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>



@if($viewModel->questionnaire)
    @include('landingpages.modals.questionnaire')
    @include('landingpages.modals.questionnaire-responded')
    @if ($viewModel->feedbackQuestionnaire)
        @include('landingpages.modals.questionnaire-feedback')
    @endif

@endif
