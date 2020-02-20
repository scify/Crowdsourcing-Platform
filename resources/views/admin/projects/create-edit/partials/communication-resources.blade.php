<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <label class="col-sm-12 control-label" for="about">Congratulations email intro text (<span
                                class="red">*</span>)</label>
                    <div class="col-sm-12">
                        <div class="form-group has-feedback">
                                        <textarea id="questionnaire_response_email_intro_text"
                                                  class="form-control summernote"
                                                  name="questionnaire_response_email_intro_text"
                                                  placeholder="About Text">{{ old('questionnaire_response_email_intro_text') ? old('questionnaire_response_email_intro_text') : $viewModel->project->communicationResources->questionnaire_response_email_intro_text }}</textarea>
                            <span class="help-block"><strong>{{ $errors->first('questionnaire_response_email_intro_text') }}</strong></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-12 control-label" for="about">Congratulations email outro text (<span
                                class="red">*</span>)</label>
                    <div class="col-sm-12">
                        <div class="form-group has-feedback">
                                        <textarea id="questionnaire_response_email_outro_text"
                                                  class="form-control summernote"
                                                  name="questionnaire_response_email_outro_text"
                                                  placeholder="About Text">{{ old('questionnaire_response_email_outro_text') ? old('questionnaire_response_email_outro_text') : $viewModel->project->communicationResources->questionnaire_response_email_outro_text }}</textarea>
                            <span class="help-block"><strong>{{ $errors->first('questionnaire_response_email_outro_text') }}</strong></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
