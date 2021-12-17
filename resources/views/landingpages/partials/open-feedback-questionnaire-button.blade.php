<a href="javascript:void(0)"
   class="{{$css_class}} w-100 respond-questionnaire feedback "
   data-questionnaire-id="{{$viewModel->feedbackQuestionnaire->id}}"
   {{-- If url has an open=1 (ex. /en/air-quality-athens?open=1) query parameter, then this questionnaire may open
     We say that it "may" open, because this partial is not always included in the the top of the landing page.
     It could be also the regural "Main (type_id=1) questionnaire
     --}}
   data-open-on-load={{$viewModel->openQuestionnaireWhenPageLoads?"1":"0"}}
   data-url="{{route('respond-questionnaire')}}"
   data-toggle="modal" data-target="#questionnaire-feedback-modal">
    {{$label}}
</a>
