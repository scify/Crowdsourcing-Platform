@if ($viewModel->questionnaire)
    <div id="questionnaire-wrapper" class="text-center content-container ">
        <h3 class="questionnaire-section-title">{{ $viewModel->userResponse?"You have already participated, thank you!":   $viewModel->questionnaire->title }}</h3>
        @if(!$viewModel->userResponse)
            <div class="questionnaire-description">{!! $viewModel->questionnaire->description !!}</div>
            @include("landingpages.partials.open-questionnaire-button")
        @endif

    </div>

@else
    <div id="questionnaire-wrapper" class="text-center content-container ">
        <h3 class="questionnaire-section-title">No active questionnaires</h3>
    </div>
@endif



@if($viewModel->questionnaire)
    @include('landingpages.modals.questionnaire')
    @include('landingpages.modals.questionnaire-responded')
@endif