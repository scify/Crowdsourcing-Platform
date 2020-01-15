@push('css')
    <link rel="stylesheet" href="{{ asset('dist/css/next-step.css') }}">
@endpush

<div class="row nextStepContainer">
    <div class="col-md-12">
        <h4 class="title">{!! $nextStepVM->title !!}</h4>
        <div class="nextStepImgContainer">
            <img class="nextStepImg" src="{{asset("images/badges/" . $nextStepVM->imgFileName)}}">
        </div>
    </div>
    @if($nextStepVM->userHasAlreadyAnsweredTheActiveQuestionnaire)
        <div class="col-md-12">
            @include('questionnaire.social-share', ['viewModel' => $nextStepVM->socialShareVM])
        </div>
    @else
        <div class="col-md-12">
            <a href="{{url("/" . $nextStepVM->project->slug . "?open=1")}}" class="btn btn-primary btn-lg nextStepActionBtn">Speak up</a>
        </div>
    @endif
</div>
