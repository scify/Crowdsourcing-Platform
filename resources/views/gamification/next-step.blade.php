@push('css')
    @vite('resources/assets/sass/gamification/next-step.scss')
@endpush

<div class="container-fluid nextStepContainer h-100 p-2">
    <div class="row justify-content-center align-self-center">

        @if(isset($questionnaire->projects[0]))
            <div class="col-md-12">
                <div class="project-img-container">
                    <a href="{{ route('project.landing-page', ['locale' => app()->getLocale(), 'slug' => $questionnaire->projects[0]?->slug]) }}">
                        <img loading="lazy" class="project-logo"
                             alt="Project logo for {{$questionnaire->projects[0]?->defaultTranslation->name}}"
                             src="{{asset($questionnaire->projects[0]?->logo_path)}}">
                        <br>
                    </a>
                </div>
                <p class="title my-2">
                    @if($questionnaire->type_id == \App\BusinessLogicLayer\lkp\QuestionnaireTypeLkp::FEEDBACK_QUESTIONNAIRE)
                        {{ __("questionnaire.answer_to_feedback_questionnaire") }}
                    @else
                        {!! $nextStepVM->title !!}
                    @endif
                </p>
                @if($nextStepVM->userHasAlreadyAnsweredTheActiveQuestionnaire)
                    @if($questionnaire->type_id == \App\BusinessLogicLayer\lkp\QuestionnaireTypeLkp::FEEDBACK_QUESTIONNAIRE)
                        <a href="{{route("project.landing-page", $questionnaire->projects->get(0)?->slug) . "?open=1"}}"
                           class="btn btn-primary btn-lg nextStepActionBtn">{{ __("questionnaire.give_us_feedback") }}</a>
                    @else
                        <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 mx-auto social-share-container">
                            @include('questionnaire.social-share', ['viewModel' => $nextStepVM->socialShareVM, 'projects'=>$nextStepVM->projects])
                        </div>
                    @endif
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
                    @elseif($nextStepVM->projects->count() == 1)
                        <a href="{{route("project.landing-page", $questionnaire->projects->get(0)?->slug) . "?open=1"}}"
                           class="btn btn-primary btn-lg nextStepActionBtn">{{ __("badges_messages.contribute") }}</a>
                    @endif
                @endif
            </div>
        @endif
    </div>
</div>

