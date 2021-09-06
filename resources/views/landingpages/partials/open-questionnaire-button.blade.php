@if($viewModel->questionnaire)
    @if(!$viewModel->userResponse)
        <a href="javascript:void(0)"
           class="btn btn-primary respond-questionnaire {{ !$viewModel->project->lp_show_speak_up_btn ? 'hidden' : '' }}"
           style="color: {{ $viewModel->project->lp_questionnaire_btn_color }};
                   background-color: {{ $viewModel->project->lp_questionnaire_btn_bg_color }};"
           data-open-on-load={{$viewModel->openQuestionnaireWhenPageLoads?"1":"0"}}
                   data-questionnaire-id="{{$viewModel->questionnaire->id}}"
           data-url="{{route('respond-questionnaire')}}"
           data-toggle="modal" data-target="#questionnaire-modal">
            Contribute
        </a>
    @else
        <h2 class="mt-3 text-center">You have already answered this questionnaire.<br>Thank you for your response!</h2>
    @endif
@endif
