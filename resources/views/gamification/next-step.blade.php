@push('css')
    <link rel="stylesheet" href="{{ mix('dist/css/next-step.css') }}">
@endpush

<div class="container-fluid nextStepContainer h-100 p-2">
    <div class="row justify-content-center align-self-center">

        <div class="col-md-12">
            <h4 class="title">{!! $nextStepVM->title !!}</h4>
            <div class="nextStepImgContainer">
                <img loading="lazy" class="nextStepImg" src="{{asset("images/badges/" . $nextStepVM->imgFileName)}}">
            </div>

            @if($nextStepVM->userHasAlreadyAnsweredTheActiveQuestionnaire)

                @include('questionnaire.social-share', ['viewModel' => $nextStepVM->socialShareVM])

            @else
                @if($nextStepVM->projects->count() > 1)
                    <div class="dropdown show">
                        <a class="btn btn-primary btn-lg nextStepActionBtn dropdown-toggle" href="#" role="button"
                           id="dropdownMenuLink"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Contribute
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            @foreach($nextStepVM->projects as $project)
                                <a href="{{route("project.landing-page", $project->slug) . "?open=1"}}"
                                   class="btn btn-light w-100 mb-2 text-left">
                                    Contribute for {{ $project->defaultTranslation->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a href="{{route("project.landing-page", $nextStepVM->projects->get(0)->slug) . "?open=1"}}"
                       class="btn btn-primary btn-lg nextStepActionBtn">Contribute</a>
                @endif

            @endif
        </div>
    </div>
</div>

