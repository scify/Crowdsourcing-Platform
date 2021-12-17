{{-- $viewModel->project->lp_show_speak_up_btn is probably obsolete, it seems it is always true --}}
<a href="javascript:void(0)"
   class="btn btn-primary w-100 respond-questionnaire call-to-action {{ !$viewModel->project->lp_show_speak_up_btn ? 'hidden' : '' }}"
   {{-- If url has an open=1 (ex. /en/air-quality-athens?open=1) query parameter, then this questionnaire may open
     We say that it "may" open, because this partial is not always included in the the top of the landing page.
     It could be also the feedback "Feedback (type_id=2) questionnaire
     --}}
   data-open-on-load={{$viewModel->openQuestionnaireWhenPageLoads?"1":"0"}}
   data-questionnaire-id="{{$viewModel->questionnaire->id}}"
   data-url="{{route('respond-questionnaire')}}"
   data-toggle="modal" data-target="#questionnaire-modal">
    {{$label}}
</a>
