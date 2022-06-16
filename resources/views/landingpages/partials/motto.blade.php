<div id="project-motto-container" class="row h-100 w-100 align-items-center mx-0 bg-img"
     style="background-image: url({{asset($viewModel->project->img_path)}});">
    <div class="overlay-filter"
         style="background-color: {{ $viewModel->project->lp_primary_color }};
                 top: @if (App::environment('staging')) 128.75px @else 93.75px @endif"></div>
    <div class="col-lg-7 col-md-8 col-sm-11 mx-auto motto-content px-0">
        <div class="frosted"></div>
        <div id="project-motto" class="container-fluid">
            <div class="row mb-3 text-center">
                <div class="col">
                    <h1 id="motto-title" class="text">{!! $viewModel->project->currentTranslation->motto_title !!}</h1>
                </div>
            </div>
            @if($viewModel->project->currentTranslation->motto_subtitle)
                <div class="row mb-0">
                    <div class="col">
                        <h4 id="motto-subtitle"
                            class="text text-center">{!! $viewModel->project->currentTranslation->motto_subtitle !!}</h4>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-10 col-sm-11 mx-auto">
                    <div class="container-fluid">
                        <div class="row">
                            {{-- PROJECT HAVE AN ACTIVE QUESTIONNAIRE --}}
                            @if($viewModel->questionnaire)
                                {{-- USER RESPONDED TO THE QUESTIONNAIRE --}}
                                @if($viewModel->userResponse)
                                    <div class="col-12">
                                        <h2 class="mt-3 text-center">
                                            @if(!$viewModel->thankYouMode)
                                                {{ __("questionnaire.already_answered") }}
                                            @endif
                                            <br>
                                            {{ __("questionnaire.thank_you_for_your_response") }}

                                            {{-- IF HE HAS  RESPONDEDED TO THE FEEDBACK ALREADY, DISPLAY THE TITLE TO INVITE TO SHARE ON SOCIAL--}}
                                            @if (!$viewModel->displayFeedbackQuestionnaire() && $viewModel->shareUrlForFacebook!=null && $viewModel->shareUrlForTwitter!=null)
                                                {{ __("questionnaire.invite_your_friends_to_answer")}}:
                                            @endif
                                        </h2>
                                    </div>
                                    {{-- IF HE HAS NOT RESPONDEDED TO THE FEEDBACK, INVITE HIM TO DO SO--}}
                                    @if ($viewModel->displayFeedbackQuestionnaire())
                                        <div class="col-md-5 col-sm-12 mx-auto">
                                            @include("landingpages.partials.open-feedback-questionnaire-button",
                                                        [
                                                            "css_class"=> "btn btn-primary w-100 call-to-action ",
                                                            "label"=>  __("questionnaire.give_us_feedback")
                                                        ])
                                        </div>
                                    @else
                                        <div class="col-md-5 col-sm-12 mx-auto ">
                                            {{-- DISPLAY SHARE THE QUESTIONNARE --}}
                                            @if($viewModel->shareUrlForFacebook || $viewModel->shareUrlForTwitter)

                                                @include('landingpages.partials.share-questionnaire-on-social', ["viewModel"=>$viewModel])

                                            @endif
                                        </div>

                                    @endif
                                    @if($viewModel->thankYouMode)
                                        <div class="container mt-5">
                                            <div class="row">
                                                <div class="col-md-8 col-sm-12 mx-auto text-center">
                                                    <a href="{{ route('my-dashboard') }}"
                                                       class="btn btn-primary btn-lg">
                                                        {{ __("menu.my_dashboard") }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    {{-- INVITE HIM TO RESPOND TO THE PROJECT QUESTIONNAIRE --}}
                                    <div class="col-md-5 col-sm-12 mx-auto">
                                        @include("landingpages.partials.open-questionnaire-button", ["label"=>  __("questionnaire.answer_the_questionnaire") ])
                                    </div>
                                @endif
                            @else
                                {{-- PROJECT DOES NOT HAVE AN ACTIVE QUESTIONNAIRE --}}
                                @include('landingpages.partials.external-url')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
