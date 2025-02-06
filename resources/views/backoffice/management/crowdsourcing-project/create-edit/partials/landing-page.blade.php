<div class="row">
    <div class="col-12">

        <div class="container-fluid no-gutters px-0">
            <div class="row no-gutters">
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
                                                 alt="Selected motto background">
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
                                    <label class="col-sm-12 control-label" for="motto">Project Motto Title (<span
                                                class="red">*</span>)</label>
                                    <div class="col-sm-12">
                                        <div class="form-group has-feedback">
                                        <textarea id="motto" class="form-control" name="motto_title"
                                                  placeholder="Project Motto">{{ old('motto_title') ? old('motto_title') : $viewModel->project->defaultTranslation->motto_title }}</textarea>
                                            <span class="help-block"><strong>{{ $errors->first('motto_title') }}</strong></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-12 control-label" for="motto_subtitle">Project Motto
                                        Subtitle (<span
                                                class="red">*</span>)</label>
                                    <div class="col-sm-12">
                                        <div class="form-group has-feedback">
                                        <textarea id="motto_subtitle" class="form-control" name="motto_subtitle"
                                                  placeholder="Project Motto Subtitle">{{ old('motto_subtitle') ? old('motto_subtitle') : $viewModel->project->defaultTranslation->motto_subtitle }}</textarea>
                                            <span class="help-block"><strong>{{ $errors->first('motto_subtitle') }}</strong></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb">
                                    <label class="col-md-12 control-label" for="lp_primary_color">Landing page primary
                                        color
                                        (<span
                                                class="red">*</span>)<br>
                                    </label>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-group colorpicker-component color-picker">
                                            <input id="lp_primary_color" type="text" name="lp_primary_color"
                                                   class="form-control"
                                                   value="{{ old('lp_primary_color') ? old('lp_primary_color') :
                                                            $viewModel->project->lp_primary_color  }}" />
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb">
                                    <label class="col-md-12 control-label" for="lp_btn_text_color_theme">Landing page
                                        button text
                                        theme
                                        (<span
                                                class="red">*</span>)<br>
                                    </label>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-group colorpicker-component color-picker">
                                            <select id="lp_btn_text_color_theme" name="lp_btn_text_color_theme"
                                                    class="form-control">
                                                <option value="light"
                                                        {{ old('lp_btn_text_color_theme') == 'light' ? 'selected' : ($viewModel->project->lp_btn_text_color_theme == 'light' ? 'selected' : '') }}>
                                                    Light
                                                </option>
                                                <option value="dark"
                                                        {{ old('lp_btn_text_color_theme') == 'dark' ? 'selected' : ($viewModel->project->lp_btn_text_color_theme == 'dark' ? 'selected' : '') }}>
                                                    Dark
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-check">
                                            <input {{ $viewModel->project->lp_show_speak_up_btn ? 'checked' : ''  }} class="form-check-input"
                                                   type="checkbox" name="lp_show_speak_up_btn" value="1"
                                                   id="show-speak-up-btn">
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
                                                  placeholder="About Text">{{ old('about') ? old('about') : $viewModel->project->defaultTranslation->about }}</textarea>
                                            <span class="help-block"><strong>{{ $errors->first('about') }}</strong></span>
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
                                <div class="row image-input-container">
                                    <label class="col-sm-12 control-label">Questionnaire Background Image </label>
                                    <div class="col-sm-12">
                                        <div class="image-preview-container">
                                            <img loading="lazy" class="selected-image-preview"
                                                 src="{{asset($viewModel->project->lp_questionnaire_img_path)}}"
                                                 alt="Selected questionnaire background">
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
                                                  placeholder="Footer Section">{{ old('footer') ? old('footer') : $viewModel->project->defaultTranslation->footer }}</textarea>
                                            <span class="help-block"><strong>{{ $errors->first('footer') }}</strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-info collapsed-card">
                        <div class="card-header">
                            <h2 class="card-title">Sticky Banner</h2>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row my-2">
                                    <div class="col">
                                        <div class="checkbox icheck">
                                            <label>
                                                <input
                                                        {{$viewModel->project->display_landing_page_banner ? 'checked' : ''}}
                                                        class="icheck-input" type="checkbox"
                                                        name="display_landing_page_banner"><span class="ml-3">
                                            Display Landing page banner</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-sm-12 control-label" for="footer">Sticky Banner Title</label>
                                    <div class="col-sm-12">
                                        <div class="form-group has-feedback">
                                            <input id="banner_title" type="text"
                                                   name="banner_title"
                                                   class="form-control"
                                                   value="{{ old('banner_title') ? old('banner_title') :
                                                            $viewModel->project->defaultTranslation->banner_title  }}" />
                                            <span class="help-block"><strong>{{ $errors->first('banner_title') }}</strong></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-12 control-label" for="footer">Sticky Banner Text</label>
                                    <div class="col-sm-12">
                                        <div class="form-group has-feedback">
                                        <textarea id="banner_text" class="form-control summernote"
                                                  name="banner_text"
                                                  placeholder="Footer Section">{{ old('banner_text') ? old('banner_text') : $viewModel->project->defaultTranslation->banner_text }}</textarea>
                                            <span class="help-block"><strong>{{ $errors->first('banner_text') }}</strong></span>
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
