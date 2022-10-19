<div class="modal fade questionnaire-modal" id="questionnaire-feedback-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{$viewModel->feedbackQuestionnaire->fieldsTranslation->title}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid mb-5">
                    @if($viewModel->feedbackQuestionnaire->fieldsTranslation->description)
                        <div class="row">
                            <div class="col-12">
                                <div class="description-container">
                                    <div class="description">
                                        <h5>{!! $viewModel->feedbackQuestionnaire->fieldsTranslation->description !!}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endif
                    <questionnaire-display
                            survey-container-id="quest_survey"
                            :user='@json($viewModel->getLoggedInUser())'
                            :user-response-data='@json($viewModel->userFeedbackQuestionnaireResponse)'
                            :questionnaire='@json($viewModel->feedbackQuestionnaire)'
                            :project='@json($viewModel->project)'
                            :languages='@json($viewModel->languages)'>
                    </questionnaire-display>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script defer src="{{mix('dist/js/questionnaire-feedback.js')}}"></script>
@endpush