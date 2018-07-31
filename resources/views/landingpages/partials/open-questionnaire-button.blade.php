@if($viewModel->questionnaire)
    @if(\Auth::user())
        <a href="javascript:void(0)"
           class="btn btn-primary respond-questionnaire"
           data-open-on-load ={{$viewModel->openQuestionnaireWhenPageLoads?"1":"0"}}
           data-questionnaire-id="{{$viewModel->questionnaire->id}}"
           data-url="{{route('respond-questionnaire')}}"
           data-toggle="modal" data-target="#questionnaire-modal">
            Speak up {{--<i class="fa fa-angle-right"></i>--}}
        </a>
    @else
        <a href="/login?submitQuestionnaire=1&redirectTo={{urlencode($viewModel->project->slug."?open=1")}}"
           class="btn btn-primary respond-questionnaire">
            Speak up {{--<i class="fa fa-angle-right"></i>--}}
        </a>
    @endif
@endif
