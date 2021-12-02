<div id="questionnaire-wrapper">
    <div class="container">
        <div id="questionnaire"
             class="align-items-center mx-0"
             style="background-image: url('{{ asset($viewModel->project->lp_questionnaire_img_path) }}')">
            @if ($viewModel->questionnaire)
                <div class="text-center content-container"
                     style="background: {{ $viewModel->project->lp_primary_color }}D9">
                    <h3 class="questionnaire-section-title">
                        {{ $viewModel->userResponse?"You have already participated, thank you!":   $viewModel->questionnaire->currentFieldsTranslation->title }}
                    </h3>
                    @if(!$viewModel->userResponse)
                        <div class="questionnaire-description mb-5">
                            {!! $viewModel->questionnaire->currentFieldsTranslation->description !!}
                        </div>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6 col-sm-11 mx-auto">
                                    @include("landingpages.partials.open-questionnaire-button",["label"=>"Start answering"])
                                </div>
                            </div>                        
                        </div>
                    @endif
                </div>
            @else
                <div class="text-center content-container">
                    <div>
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
