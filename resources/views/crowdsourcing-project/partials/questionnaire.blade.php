<div id="questionnaire-wrapper" class="py-5">
    <div class="container">
        <div id="questionnaire"
             class="align-items-center mx-0"
             style="background-image: url('{{ asset($viewModel->project->lp_questionnaire_img_path) }}')">
            @if ($viewModel->questionnaire)
                <div class="text-center content-container">
                    <div class="content w-100 h-100">
                        <h3 class="project-section-title text-center">
                            {{ $viewModel->userResponse? __("questionnaire.already_participated"):   $viewModel->questionnaire->fieldsTranslation->title }}
                        </h3>
                        @if(!$viewModel->userResponse)
                            <div class="questionnaire-description mb-5 text-center">
                                {!! $viewModel->questionnaire->fieldsTranslation->description !!}
                            </div>

                            <div style="background-image: url('/images/project_lp_questionnaire.webp'); background-size: contain; background-repeat: no-repeat; width: 100%; aspect-ratio: 2.782;"></div>

                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-10 col-md-10 col-sm-11 mx-auto">
                                        <div class="row">
                                            <div class="col-md-9 col-sm-12 mx-auto mt-5">
                                                <a href="{{ route('show-questionnaire-page', ['project' => $viewModel->project->slug,'questionnaire' => $viewModel->questionnaire->id]) }}"
                                                   class="btn btn-primary w-100 respond-questionnaire call-to-action
                                            {{ !$viewModel->project->lp_show_speak_up_btn ? 'hidden' : '' }}">
                                                    {{__("questionnaire.start_answering")}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @if ($viewModel->feedbackQuestionnaire)
                    <hr class="my-5">
                    <div class="text-center content-container"
                         style="background: {{ $viewModel->project->lp_primary_color }}D9">
                        <div class="questionnaire-description mb-5">
                            {!! $viewModel->feedbackQuestionnaire->fieldsTranslation->description !!}
                        </div>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-10 col-md-10 col-sm-11 mx-auto">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 mx-auto mt-5">
                                            @if($viewModel->userFeedbackQuestionnaireResponse)
                                                <p>{{__("questionnaire.user_feedback_given_message")}}</p>
                                            @else
                                                <a href="{{ route('show-questionnaire-page', ['project' => $viewModel->project->slug,'questionnaire' => $viewModel->feedbackQuestionnaire->id]) }}"
                                                   class="btn btn-primary w-100 respond-questionnaire call-to-action">
                                                    {{__("questionnaire.answer_to_feedback_questionnaire")}}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center content-container">
                    <div>
                        @if ($viewModel->project->status_id == App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp::FINALIZED)
                            <h3 class="project-section-title">{{ __("questionnaire.project_finalized") }}</h3>
                        @else
                            <h3 class="project-section-title">{{ __("questionnaire.no_active_questionnaires") }}</h3>
                            <h3 class="project-section-title">{{ __("questionnaire.next_questionnaire") }}</h3>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@if($viewModel->questionnaire)

@endif
