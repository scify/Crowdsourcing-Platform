@push('css')
    <link rel="stylesheet" href="{{ asset('dist/css/next-step.css') }}">
@endpush

<div class="row nextStepContainer">
    <div class="col-md-12">
        <h4 class="title">What to do next?</h4>
        <h5>{{ $nextStepVM->subtitle }}</h5>
        <div class="nextStepImgContainer">
            <img class="nextStepImg" src="{{asset("images/badges/" . $nextStepVM->imgFileName)}}">
        </div>
    </div>
    {{--@if($nextStepVM->projectHasActiveQuestionnaire)--}}
        {{--<div class="col-md-12">--}}
            {{--<a href="{{url("/" . $nextStepVM->project->slug . "#questionnaire")}}" class="btn btn-primary btn-lg nextStepActionBtn">Go to the Questionnaire</a>--}}
        {{--</div>--}}
    {{--@endif--}}
    <div class="col-md-12">
        @include('questionnaire.social-share')
    </div>
</div>