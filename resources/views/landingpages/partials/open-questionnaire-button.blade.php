@if($viewModel->questionnaire)
    @if(\Auth::user())
        @if(!$viewModel->userResponse)
            <a href="javascript:void(0)"
               class="btn btn-primary respond-questionnaire {{ !$viewModel->project->lp_show_speak_up_btn ? 'hidden' : '' }}"
               style="color: {{ $viewModel->project->lp_questionnaire_btn_color }};
                       background-color: {{ $viewModel->project->lp_questionnaire_btn_bg_color }};"
               data-open-on-load={{$viewModel->openQuestionnaireWhenPageLoads?"1":"0"}}
                       data-questionnaire-id="{{$viewModel->questionnaire->id}}"
               data-url="{{route('respond-questionnaire')}}"
               data-toggle="modal" data-target="#questionnaire-modal">
                Speak up
            </a>
        @endif
    @else
        <a href="{{ $viewModel->getSignInURLWithParameters() }}"
           class="btn btn-primary respond-questionnaire"
           style="color: {{ $viewModel->project->lp_questionnaire_btn_color }};
                   background-color: {{ $viewModel->project->lp_questionnaire_btn_bg_color }};">
            Speak up
        </a>
    @endif
@endif
