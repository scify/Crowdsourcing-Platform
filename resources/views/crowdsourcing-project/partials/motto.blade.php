<div id="project-motto-container" class="row h-100 w-100 align-items-center mx-0 bg-img"
     style="background-image: url({{asset($viewModel->project->img_path)}}); position: relative;">
    <div class="overlay-filter {{ $viewModel->thankYouMode ? 'overlay-thanks' : '' }}"></div>
    <div class="col-lg-7 col-md-8 col-sm-11 mx-auto motto-content">
        <div class="frosted"></div>
        <div id="project-motto" class="h-100">
            <div class="container">
                <div class="row title-row mb-3 text-center">
                    <div class="col-12 px-5">
                        <h1 id="motto-title"
                            class="text">{!! $viewModel->project->currentTranslation->motto_title !!}</h1>
                        @if($viewModel->project->currentTranslation->motto_subtitle)
                            <h4 id="motto-subtitle"
                                class="text text-center pt-5">{!! $viewModel->project->currentTranslation->motto_subtitle !!}</h4>
                        @endif
                    </div>
                </div>
                <div class="row pt-3 pb-5">
                    <div class="col-md-10 col-sm-11 mx-auto">
                        <div class="container-fluid">
                            <div class="row">
                                {{-- PROJECT HAVE AN ACTIVE QUESTIONNAIRE --}}
                                @if($viewModel->questionnaire)
                                    {{-- USER RESPONDED TO THE QUESTIONNAIRE --}}
                                    @if($viewModel->userResponse)
                                        @if($viewModel->projectHasPublishedProblems && !$viewModel->thankYouMode)
                                            <a href="{{ route('project.problems-page', ['project_slug' => $viewModel->project->slug]) }}"
                                               class="btn btn-primary call-to-action mx-auto">
                                                {{__("project-problems.project_landing_page_problems_action_button")}}
                                                <i
                                                        class="fas fa-arrow-right"></i></a>
                                        @else
                                            <div class="col-12">
                                                <h4 class="{{ $viewModel->thankYouMode ? 'mt-0' : 'mt-3' }} mb-4 text-center">
                                                    @if(!$viewModel->thankYouMode)
                                                        {{ __("questionnaire.already_answered") }}
                                                    @endif
                                                    {{ __("questionnaire.thank_you_for_your_response") }}
                                                </h4>
                                                @if($viewModel->thankYouMode && isset($badge))
                                                    <div class="container mt-5">
                                                        <div class="row mb-4">
                                                            <div class="col-md-8 col-sm-12 mx-auto text-center">
                                                                @include('gamification.badge-single', ['badge' => $badge])
                                                            </div>
                                                        </div>
                                                        @if(\Illuminate\Support\Facades\Auth::check())
                                                            <div class="row">
                                                                <div class="col-md-7 col-sm-12 mx-auto text-center">
                                                                    <h3 class="dashboard-message w-100">{{ __('questionnaire.visit_dashboard_and_invite') }}</h3>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4 col-sm-9 mx-auto text-center">
                                                                    @if($viewModel->projectHasPublishedProblems)
                                                                        <a href="{{ route('project.problems-page', ['project_slug' => $viewModel->project->slug]) }}"
                                                                           class="btn btn-primary call-to-action mx-auto">
                                                                            {{__("project-problems.project_landing_page_problems_action_button")}}
                                                                            <i
                                                                                    class="fas fa-arrow-right"></i></a>
                                                                    @else
                                                                        <a href="{{ route('my-dashboard') }}"
                                                                           class="btn btn-primary btn-lg w-100 dashboard-btn">
                                                                            {{ __("menu.my_dashboard") }}
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                                <br>
                                            </div>
                                        @endif
                                        {{-- IF HE HAS NOT RESPONDEDED TO THE FEEDBACK, INVITE HIM TO DO SO--}}
                                        @if ($viewModel->displayFeedbackQuestionnaire())
                                            <div class="col-md-9 col-sm-12 mx-auto">
                                                <a href="{{ route('show-questionnaire-page', ['project' => $viewModel->project->slug,'questionnaire' => $viewModel->feedbackQuestionnaire->id]) }}"
                                                   class="btn btn-primary w-100 respond-questionnaire call-to-action">
                                                    {{__("questionnaire.give_us_feedback")}}
                                                </a>
                                            </div>
                                        @else
                                            {{-- DISPLAY INVITE TO SHARE ON SOCIAL --}}
                                            @if($viewModel->shareUrlForFacebook || $viewModel->shareUrlForTwitter)

                                                <div class="col-12">
                                                    <h4 class="mb-3 text-center">
                                                        {{ __("questionnaire.invite_your_friends_to_answer") }}:
                                                    </h4>
                                                </div>

                                                <div class="col-10 col-md-12 mx-auto d-flex flex-wrap justify-content-center social-share">
                                                    @include('crowdsourcing-project.partials.share-questionnaire-on-social', ["viewModel"=>$viewModel])
                                                </div>

                                            @endif
                                        @endif
                                    @else
                                        {{-- INVITE HIM TO RESPOND TO THE PROJECT QUESTIONNAIRE --}}
                                        <div class="col-md-9 col-sm-12 mx-auto">
                                            <a href="{{ route('show-questionnaire-page', ['project' => $viewModel->project->slug,'questionnaire' => $viewModel->questionnaire->id]) }}"
                                               class="btn btn-primary w-100 respond-questionnaire call-to-action
                                            {{ !$viewModel->project->lp_show_speak_up_btn ? 'hidden' : '' }}">
                                                {{__("questionnaire.answer_the_questionnaire")}}
                                            </a>
                                        </div>
                                    @endif
                                @elseif($viewModel->projectHasPublishedProblems)
                                    <a href="{{ route('project.problems-page', ['project_slug' => $viewModel->project->slug]) }}"
                                       class="btn btn-primary call-to-action mx-auto">
                                        {{__("project-problems.project_landing_page_problems_action_button")}} <i
                                                class="fas fa-arrow-right"></i></a>
                                @else
                                    @include('crowdsourcing-project.partials.external-url')
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
