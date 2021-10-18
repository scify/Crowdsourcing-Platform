<div id="questionnaire-wrapper" class="container">
    <div class="row  align-items-center mx-0" id="questionnaire"
     style="background-image: url('{{ asset($viewModel->project->lp_questionnaire_img_path) }}')">
    <div class="col-md-12 p-0">
        @if ($viewModel->questionnaire)
            <div id="questionnaire-wrapper" class="text-center content-container">
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
            <div id="questionnaire-wrapper" class="text-center content-container ">
                <div
                        style="color: {{ $viewModel->project->lp_questionnaire_color }}">
                    @if ($viewModel->project->status_id == App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp::FINALIZED)
                        <h3 class="questionnaire-section-title">This project has been finalized.</h3>
                        @if($viewModel->project->external_url)
                            <h3 class="questionnaire-section-title">Check out the project's webpage:</h3>
                            <div class="row">
                                <div class="col-lg-2 col-md-4 col-sm-10 call-to-action mx-auto text-center">
                                    <a href="{{$viewModel->project->external_url}}" target="_blank"
                                       class="btn btn-primary btn-lg">Project
                                        Webpage</a>
                                </div>
                            </div>
                        @endif
                    @else
                        <h3 class="questionnaire-section-title">No active questionnaires</h3>
                        <h3 class="questionnaire-section-title">Our next questionnaire is on its way: stay tuned!</h3>
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
