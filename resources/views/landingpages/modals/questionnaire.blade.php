<div class="modal fade questionnaire-modal " id="questionnaire-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{$viewModel->questionnaire->fieldsTranslation->title}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid mb-5">
                    @if($viewModel->questionnaire->fieldsTranslation->description)
                        <div class="row">
                            <div class="col-12">
                                <div class="description-container">
                                    <div class="description">
                                        <h5>{!! $viewModel->questionnaire->fieldsTranslation->description !!}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endif
                    @if ($viewModel->shouldShowQuestionnaireStatisticsLink())
                        <div class="row mt-4">
                            <div class="col-md-12 text-left">
                                <h3>{{ __("questionnaire.check_what_other_respondents")}}
                                    <a href="{{route('questionnaire.statistics', ['questionnaire' => $viewModel->questionnaire->id])}}"
                                       target="_blank">{{ __("questionnaire.here")}}.</a></h3>
                            </div>
                        </div>
                        <hr>
                    @endif
                    <questionnaire-display
                            survey-container-id="questionnaire_project"
                            id-of-modal-to-open-when-submitted="questionnaire-responded"
                            :user='@json($viewModel->getLoggedInUser())'
                            :user-response='@json($viewModel->userResponse)'
                            :questionnaire='@json($viewModel->questionnaire)'
                            :project='@json($viewModel->project)'
                            :languages='@json($viewModel->languages)'>
                    </questionnaire-display>
                </div>
            </div>
        </div>
    </div>
</div>
