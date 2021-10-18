<a href="javascript:void(0)"
   class="btn btn-primary w-100 respond-questionnaire {{ !$viewModel->project->lp_show_speak_up_btn ? 'hidden' : '' }}"
   style="color: {{ $viewModel->project->lp_questionnaire_btn_color }};
           background-color: {{ $viewModel->project->lp_questionnaire_btn_bg_color }};"
   data-open-on-load={{$viewModel->openQuestionnaireWhenPageLoads?"1":"0"}}
           data-questionnaire-id="{{$viewModel->questionnaire->id}}"
   data-url="{{route('respond-questionnaire')}}"
   data-toggle="modal" data-target="#questionnaire-modal">
    {{$label}}
</a>
