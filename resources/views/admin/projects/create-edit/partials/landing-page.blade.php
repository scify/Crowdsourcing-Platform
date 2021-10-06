<div class="row">
    <div class="col-12">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mx-auto">
                    <div class="card card-info collapsed-card">
                        <div class="card-header">
                            <h2 class="card-title">Motto Section</h2>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row image-input-container">
                                    <label class="col-sm-12 control-label">Motto Background Image </label>
                                    <div class="col-sm-12">
                                        <div class="image-preview-container">
                                            <img loading="lazy" class="selected-image-preview"
                                                 src="{{asset($viewModel->project->img_path) ? asset($viewModel->project->img_path) : ''}}"
                                                 alt="Selected motto background image">
                                        </div>
                                        <div class="form-group has-feedback input-file-wrapper">
                                            <small>In order to update the currently selected image, please choose a new
                                                image by
                                                clicking the button below.
                                            </small>
                                            <input type="file" name="img" class="image-input" accept="image/*">
                                            <span class="help-block"><strong>{{ $errors->first('img') }}</strong></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-12 control-label" for="motto">Project Motto Text (<span
                                                class="red">*</span>)</label>
                                    <div class="col-sm-12">
                                        <div class="form-group has-feedback">
                                        <textarea id="motto" class="form-control" name="motto"
                                                  placeholder="Project Motto">{{ old('motto') ? old('motto') : $viewModel->project->motto }}</textarea>
                                            <span class="help-block"><strong>{{ $errors->first('motto') }}</strong></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb">
                                    <label class="col-md-12 control-label" for="lp_motto_color">Project Motto color
                                        (<span
                                                class="red">*</span>)<br>
                                    </label>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-group colorpicker-component color-picker">
                                            <input id="lp_motto_color" type="text" name="lp_motto_color"
                                                   class="form-control"
                                                   value="{{ old('lp_motto_color') ? old('lp_motto_color') :
                                                            $viewModel->project->lp_motto_color  }}"/>
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-check">
                                            <input {{ $viewModel->project->lp_show_speak_up_btn ? 'checked' : ''  }} class="form-check-input"
                                                   type="checkbox" name="lp_show_speak_up_btn" value="1" id="show-speak-up-btn">
                                            <label class="form-check-label control-label" for="show-speak-up-btn">
                                                Show "Contribute" button
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card card-info collapsed-card">
                        <div class="card-header">
                            <h2 class="card-title">About Section</h2>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <label class="col-sm-12 control-label" for="about">About Text (<span
                                                class="red">*</span>)</label>
                                    <div class="col-sm-12">
                                        <div class="form-group has-feedback">
                                        <textarea id="about" class="form-control summernote" name="about"
                                                  placeholder="About Text">{{ old('about') ? old('about') : $viewModel->project->about }}</textarea>
                                            <span class="help-block"><strong>{{ $errors->first('about') }}</strong></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb">
                                    <label class="col-md-12 control-label" for="lp_about_color">About Text color (<span
                                                class="red">*</span>)<br>
                                    </label>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-group colorpicker-component color-picker">
                                            <input id="lp_about_color" type="text" name="lp_about_color"
                                                   class="form-control"
                                                   value="{{ old('lp_about_color') ? old('lp_about_color') :
                                                            $viewModel->project->lp_about_color  }}"/>
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb">
                                    <label class="col-md-12 control-label" for="lp_about_bg_color">About Text background
                                        (<span
                                                class="red">*</span>)<br>
                                    </label>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-group colorpicker-component color-picker">
                                            <input id="lp_about_bg_color" type="text" name="lp_about_bg_color"
                                                   class="form-control"
                                                   value="{{ old('lp_about_bg_color') ? old('lp_about_bg_color') :
                                                            $viewModel->project->lp_about_bg_color  }}"/>
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card card-info collapsed-card">
                        <div class="card-header">
                            <h2 class="card-title">Active Questionnaire Section</h2>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <label class="col-md-12 control-label" for="lp_questionnaire_color">Questionnaire
                                        color (<span
                                                class="red">*</span>)<br>
                                    </label>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-group colorpicker-component color-picker">
                                            <input id="lp_questionnaire_color" type="text" name="lp_questionnaire_color"
                                                   class="form-control"
                                                   value="{{ old('lp_questionnaire_color') ? old('lp_questionnaire_color') :
                                                            $viewModel->project->lp_questionnaire_color  }}"/>
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-12 control-label" for="lp_questionnaire_btn_color">"Contribute"
                                        button text color (<span
                                                class="red">*</span>)<br>
                                    </label>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-group colorpicker-component color-picker">
                                            <input id="lp_questionnaire_btn_color" type="text"
                                                   name="lp_questionnaire_btn_color"
                                                   class="form-control"
                                                   value="{{ old('lp_questionnaire_btn_color') ? old('lp_questionnaire_btn_color') :
                                                            $viewModel->project->lp_questionnaire_btn_color  }}"/>
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-12 control-label" for="lp_questionnaire_btn_bg_color">"Speak
                                        up" button background color (<span
                                                class="red">*</span>)<br>
                                    </label>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-group colorpicker-component color-picker">
                                            <input id="lp_questionnaire_btn_bg_color" type="text"
                                                   name="lp_questionnaire_btn_bg_color"
                                                   class="form-control"
                                                   value="{{ old('lp_questionnaire_btn_bg_color') ? old('lp_questionnaire_btn_bg_color') :
                                                            $viewModel->project->lp_questionnaire_btn_bg_color  }}"/>
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row image-input-container">
                                    <label class="col-sm-12 control-label">Questionnaire Background Image </label>
                                    <div class="col-sm-12">
                                        <div class="image-preview-container">
                                            <img loading="lazy" class="selected-image-preview"
                                                 src="{{asset($viewModel->project->lp_questionnaire_img_path)}}"
                                                 alt="Selected questionnaire background image">
                                        </div>
                                        <div class="form-group has-feedback input-file-wrapper">
                                            <small>In order to update the currently selected image, please choose a new
                                                image by
                                                clicking the button below.
                                            </small>
                                            <input type="file" name="lp_questionnaire_img" class="image-input"
                                                   accept="image/*">
                                            <span class="help-block"><strong>{{ $errors->first('lp_questionnaire_img') }}</strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card card-info collapsed-card">
                        <div class="card-header">
                            <h2 class="card-title">Questionnaire Goal Section</h2>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <label class="col-md-12 control-label" for="lp_questionnaire_goal_bg_color">Goal
                                        background color (<span
                                                class="red">*</span>)<br>
                                    </label>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-group colorpicker-component color-picker">
                                            <input id="lp_questionnaire_goal_bg_color" type="text"
                                                   name="lp_questionnaire_goal_bg_color"
                                                   class="form-control"
                                                   value="{{ old('lp_questionnaire_goal_bg_color') ? old('lp_questionnaire_goal_bg_color') :
                                                            $viewModel->project->lp_questionnaire_goal_bg_color  }}"/>
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-12 control-label" for="lp_questionnaire_goal_title_color">Goal
                                        title color (<span
                                                class="red">*</span>)<br>
                                    </label>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-group colorpicker-component color-picker">
                                            <input id="lp_questionnaire_goal_title_color" type="text"
                                                   name="lp_questionnaire_goal_title_color"
                                                   class="form-control"
                                                   value="{{ old('lp_questionnaire_goal_title_color') ? old('lp_questionnaire_goal_title_color') :
                                                            $viewModel->project->lp_questionnaire_goal_title_color  }}"/>
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-12 control-label" for="lp_questionnaire_goal_color">Goal text
                                        color (<span
                                                class="red">*</span>)<br>
                                    </label>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-group colorpicker-component color-picker">
                                            <input id="lp_questionnaire_goal_color" type="text"
                                                   name="lp_questionnaire_goal_color"
                                                   class="form-control"
                                                   value="{{ old('lp_questionnaire_goal_color') ? old('lp_questionnaire_goal_color') :
                                                            $viewModel->project->lp_questionnaire_goal_color  }}"/>
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card card-info collapsed-card">
                        <div class="card-header">
                            <h2 class="card-title">Newsletter Section</h2>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="container-fluid">

                                <div class="row">
                                    <label class="col-md-12 control-label" for="lp_newsletter_bg_color">Newsletter
                                        background color (<span
                                                class="red">*</span>)<br>
                                    </label>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-group colorpicker-component color-picker">
                                            <input id="lp_newsletter_bg_color" type="text" name="lp_newsletter_bg_color"
                                                   class="form-control"
                                                   value="{{ old('lp_newsletter_bg_color') ? old('lp_newsletter_bg_color') :
                                                            $viewModel->project->lp_newsletter_bg_color  }}"/>
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-12 control-label" for="lp_newsletter_title_color">Newsletter
                                        title color (<span
                                                class="red">*</span>)<br>
                                    </label>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-group colorpicker-component color-picker">
                                            <input id="lp_newsletter_title_color" type="text"
                                                   name="lp_newsletter_title_color"
                                                   class="form-control"
                                                   value="{{ old('lp_newsletter_title_color') ? old('lp_newsletter_title_color') :
                                                            $viewModel->project->lp_newsletter_title_color  }}"/>
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-12 control-label" for="lp_newsletter_color">Newsletter text
                                        color (<span
                                                class="red">*</span>)<br>
                                    </label>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-group colorpicker-component color-picker">
                                            <input id="lp_newsletter_color" type="text" name="lp_newsletter_color"
                                                   class="form-control"
                                                   value="{{ old('lp_newsletter_color') ? old('lp_newsletter_color') :
                                                            $viewModel->project->lp_newsletter_color  }}"/>
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-12 control-label" for="lp_newsletter_btn_color">Newsletter
                                        button text color (<span
                                                class="red">*</span>)<br>
                                    </label>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-group colorpicker-component color-picker">
                                            <input id="lp_newsletter_btn_color" type="text"
                                                   name="lp_newsletter_btn_color"
                                                   class="form-control"
                                                   value="{{ old('lp_newsletter_btn_color') ? old('lp_newsletter_btn_color') :
                                                            $viewModel->project->lp_newsletter_btn_color  }}"/>
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-12 control-label" for="lp_newsletter_btn_bg_color">Newsletter
                                        button background color (<span
                                                class="red">*</span>)<br>
                                    </label>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-group colorpicker-component color-picker">
                                            <input id="lp_newsletter_btn_bg_color" type="text"
                                                   name="lp_newsletter_btn_bg_color"
                                                   class="form-control"
                                                   value="{{ old('lp_newsletter_btn_bg_color') ? old('lp_newsletter_btn_bg_color') :
                                                            $viewModel->project->lp_newsletter_btn_bg_color  }}"/>
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="card card-info collapsed-card">
                        <div class="card-header">
                            <h2 class="card-title">Footer Section</h2>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="container-fluid">

                                <div class="row">
                                    <label class="col-sm-12 control-label" for="footer">Footer Text (<span
                                                class="red">*</span>)</label>
                                    <div class="col-sm-12">
                                        <div class="form-group has-feedback">
                                        <textarea id="footer" class="form-control summernote" name="footer"
                                                  placeholder="Footer Section">{{ old('footer') ? old('footer') : $viewModel->project->footer }}</textarea>
                                            <span class="help-block"><strong>{{ $errors->first('footer') }}</strong></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb">
                                    <label class="col-md-12 control-label" for="lp_footer_color">Footer Text color
                                        (<span
                                                class="red">*</span>)<br>
                                    </label>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-group colorpicker-component color-picker">
                                            <input id="lp_footer_color" type="text" name="lp_footer_color"
                                                   class="form-control"
                                                   value="{{ old('lp_footer_color') ? old('lp_footer_color') :
                                                            $viewModel->project->lp_footer_color  }}"/>
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb">
                                    <label class="col-md-12 control-label" for="lp_footer_bg_color">Footer Text
                                        background (<span
                                                class="red">*</span>)<br>
                                    </label>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-group colorpicker-component color-picker">
                                            <input id="lp_footer_bg_color" type="text" name="lp_footer_bg_color"
                                                   class="form-control"
                                                   value="{{ old('lp_footer_bg_color') ? old('lp_footer_bg_color') :
                                                            $viewModel->project->lp_footer_bg_color  }}"/>
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
