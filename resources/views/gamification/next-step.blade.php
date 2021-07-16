@push('css')
    <link rel="stylesheet" href="{{ mix('dist/css/next-step.css') }}">
@endpush

<div class="container-fluid nextStepContainer h-100 p-2">
    <div class="row justify-content-center align-self-center">

        <div class="col-md-12">
            <h4 class="title">{!! $nextStepVM->title !!}</h4>
            <div class="nextStepImgContainer">
                <img class="nextStepImg" src="{{asset("images/badges/" . $nextStepVM->imgFileName)}}">
            </div>

            @if($nextStepVM->userHasAlreadyAnsweredTheActiveQuestionnaire)

                @include('questionnaire.social-share', ['viewModel' => $nextStepVM->socialShareVM])

            @else

                <a href="{{url("/" . $nextStepVM->project->slug . "?open=1")}}"
                   class="btn btn-primary btn-lg nextStepActionBtn">Contribute</a>

            @endif
        </div>
    </div>
</div>

