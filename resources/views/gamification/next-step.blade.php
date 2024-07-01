@push('css')
    @vite('resources/assets/sass/gamification/next-step.scss')
@endpush

<div class="container-fluid nextStepContainer h-100 p-2">
    <div class="row justify-content-center align-self-center">

        <div class="col-md-12">
            <h4 class="title">{!! $nextStepVM->title !!}</h4>
            <div class="nextStepImgContainer">
                <img alt="Next Step Badge" loading="lazy" class="nextStepImg"
                     src="{{asset("images/badges/" . $nextStepVM->imgFileName)}}">
            </div>

            @if($nextStepVM->userHasAlreadyAnsweredTheActiveQuestionnaire)

                @include('questionnaire.social-share', ['viewModel' => $nextStepVM->socialShareVM, 'projects'=>$nextStepVM->projects])

            @else
                @if($nextStepVM->projects->count() > 1)
                    <div class="dropdown show">
                        <a class="btn btn-primary btn-lg nextStepActionBtn dropdown-toggle" href="#" role="button"
                           id="dropdownMenuLink"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __("badges_messages.contribute") }}
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            @foreach($nextStepVM->projects as $project)
                                <a href="{{route("project.landing-page", $project->slug) . "?open=1"}}"
                                   class="btn btn-light w-100 mb-2 text-left">
                                    {{ __("badges_messages.contribute_for") }} {{ $project->defaultTranslation->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a href="{{route("project.landing-page", $questionnaire->projects->get(0)->slug) . "?open=1"}}"
                       class="btn btn-primary btn-lg nextStepActionBtn">{{ __("badges_messages.contribute") }}</a>
                @endif
            @endif
        </div>
    </div>
</div>

