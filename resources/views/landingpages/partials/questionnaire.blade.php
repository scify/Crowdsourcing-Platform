<div id="questionnaire-wrapper">
    <div class="container">
        <div id="questionnaire"
             class="align-items-center mx-0"
             style="background-image: url('{{ asset($viewModel->project->lp_questionnaire_img_path) }}')">
            @if ($viewModel->questionnaire)
                <div class="text-center content-container">
                    <h3 class="questionnaire-section-title"
                        style="color: {{ $viewModel->project->lp_questionnaire_color }}">
                        {{ $viewModel->userResponse?"You have already participated, thank you!":   $viewModel->questionnaire->title }}
                    </h3>
                    @if(!$viewModel->userResponse)
                        <div class="questionnaire-description"
                             style="color: {{ $viewModel->project->lp_questionnaire_color }}">
                            {!! $viewModel->questionnaire->description !!}
                        </div>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-4 col-md-5 col-sm-11 mx-auto">
                                    @include("landingpages.partials.open-questionnaire-button")
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <div class="text-center content-container ">
                    <div style="color: {{ $viewModel->project->lp_questionnaire_color }}">
                        @if ($viewModel->project->status_id == App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp::FINALIZED)
                            <h3 class="questionnaire-section-title">This project has been finalized.</h3>
                        @else
                            <h3 class="questionnaire-section-title">No active questionnaires</h3>
                            <h3 class="questionnaire-section-title">Our next questionnaire is on its way: stay
                                tuned!</h3>
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
@endif
