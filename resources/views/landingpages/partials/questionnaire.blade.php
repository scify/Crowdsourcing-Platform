<div class="row" id="questionnaire" style="background-image: url('{{ asset($viewModel->project->lp_questionnaire_img_path) }}')">
    <div class="col-md-12 no-padding">
        @if ($viewModel->questionnaire)
            <div id="questionnaire-wrapper" class="text-center content-container">
                <h3 class="questionnaire-section-title" style="color: {{ $viewModel->project->lp_questionnaire_color }}">{{ $viewModel->userResponse?"You have already participated, thank you!":   $viewModel->questionnaire->title }}</h3>
                @if(!$viewModel->userResponse)
                    <div class="questionnaire-description" style="color: {{ $viewModel->project->lp_questionnaire_color }}">{!! $viewModel->questionnaire->description !!}</div>
                    @include("landingpages.partials.open-questionnaire-button")
                @endif

            </div>

        @else
            <div id="questionnaire-wrapper" class="text-center content-container ">
                <h3 class="questionnaire-section-title" style="color: {{ $viewModel->project->lp_questionnaire_color }}">No active questionnaires<br><br>Our next questionnaire is on its way: stay tuned!</h3>
            </div>
        @endif
    </div>
</div>




@if($viewModel->questionnaire)
    @include('landingpages.modals.questionnaire')
    @include('landingpages.modals.questionnaire-responded')
@endif
