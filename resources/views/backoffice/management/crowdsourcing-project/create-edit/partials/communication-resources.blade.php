<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <label class="col-sm-12 control-label" for="about">Congratulations email</label>
                    <div class="col-sm-12">
                        <div class="row mt-2">
                            <div class="col">
                                <div class="form-check">
                                    <input
                                            {{$viewModel->project->should_send_email_after_questionnaire_response ? 'checked' : ''}}
                                            class="form-check-input" type="checkbox" name="should_send_email_after_questionnaire_response" id="should_send_email_after_questionnaire_response">
                                    <label class="form-check-label" for="should_send_email_after_questionnaire_response">
                                        Respondents to questionnaires for this project should receive a "congratulations" email.</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <label class="col-sm-12 control-label" for="about">Congratulations email intro text</label>
                    <div class="col-sm-12">
                        <div class="form-group has-feedback">
                                        <textarea id="questionnaire_response_email_intro_text"
                                                  class="form-control"
                                                  name="questionnaire_response_email_intro_text"
                                                  placeholder="About Text">{{ old('questionnaire_response_email_intro_text') ? old('questionnaire_response_email_intro_text') : $viewModel->project->defaultTranslation->questionnaire_response_email_intro_text }}</textarea>
                            <span class="help-block"><strong>{{ $errors->first('questionnaire_response_email_intro_text') }}</strong></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-12 control-label" for="about">Congratulations email outro text</label>
                    <div class="col-sm-12">
                        <div class="form-group has-feedback">
                                        <textarea id="questionnaire_response_email_outro_text"
                                                  class="form-control"
                                                  name="questionnaire_response_email_outro_text"
                                                  placeholder="About Text">{{ old('questionnaire_response_email_outro_text') ? old('questionnaire_response_email_outro_text') : $viewModel->project->defaultTranslation->questionnaire_response_email_outro_text }}</textarea>
                            <span class="help-block"><strong>{{ $errors->first('questionnaire_response_email_outro_text') }}</strong></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <h5><b>This is what the email will look like:</b></h5>
        <h6><b>(We have highlighted the changeable texts with yellow color)</b></h6>
    </div>
</div>

<div class="card card-info">
    <div class="card-header d-flex align-items-center">
        <h2 class="card-title mb-0">Contributor email</h2>
        <button type="button" class="btn btn-sm btn-link ms-auto card-collapse-toggle" data-bs-toggle="collapse"
                data-bs-target="#card-body-contributor-email" aria-expanded="false" aria-controls="card-body-contributor-email">
            <i class="fa fa-chevron-up"></i>
        </button>
    </div>
    <div class="collapse" id="card-body-contributor-email">
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        {!! $viewModel->contributorEmailView !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

