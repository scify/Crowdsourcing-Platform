<div class="modal fade questionnaire-modal" id="questionnaire-feedback-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{$viewModel->feedbackQuestionnaire->currentFieldsTranslation->title}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid mb-5">
                    @if($viewModel->feedbackQuestionnaire->currentFieldsTranslation->description)
                        <div class="row">
                            <div class="col-12">
                                <div class="description-container">
                                    <div class="description">
                                        <h5>{!! $viewModel->feedbackQuestionnaire->currentFieldsTranslation->description !!}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endif
                    <questionnaire-display
                            survey-container-id=="quest_survey"
                            :user='@json($viewModel->getLoggedInUser())'
                            :user-response='@json($viewModel->userFeedbackQuestionnaireResponse)'
                            :questionnaire='@json($viewModel->feedbackQuestionnaire)'
                            :project='@json($viewModel->project)'
                            :languages='@json($viewModel->languages)'>
                    </questionnaire-display>
                </div>
            </div>
        </div>
    </div>
</div>
