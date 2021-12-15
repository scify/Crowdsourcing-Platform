{{-- $viewModel->project->lp_show_speak_up_btn is probably obsolete, it seems it is always true --}}
<a href="javascript:void(0)"
   class="btn btn-primary w-100 respond-questionnaire call-to-action {{ !$viewModel->project->lp_show_speak_up_btn ? 'hidden' : '' }}"
   data-open-on-load={{$viewModel->openQuestionnaireWhenPageLoads?"1":"0"}}
           data-questionnaire-id="{{$viewModel->questionnaire->id}}"
   data-url="{{route('respond-questionnaire')}}"
   data-toggle="modal" data-target="#questionnaire-modal">
    {{$label}}
</a>
