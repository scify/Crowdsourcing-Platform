@extends('loggedin-environment.layout')

@section('content-header')
    <h1>{{ $viewModel->isEditMode() ? 'Edit' : 'Create' }}
        Project {{ $viewModel->isEditMode() ? ': ' . $viewModel->project->name : '' }}</h1>
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('dist/css/create-edit-project.css') }}">
@endpush

@section('content')
    <form id="project-form" enctype="multipart/form-data" role="form" method="POST"
          action="{{ $viewModel->isEditMode() ? route('projects.update', $viewModel->project) : route('projects.store') }}">
        @if($viewModel->isEditMode())
            @method('PUT')
        @endif
        <div class="container-fluid no-padding">
            <div class="row">
                <div class="col-md-12">
                    <p class="margin-top">required fields are marked with (<span class="red">*</span>)</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h2>Project Basic Details</h2>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                {{--English by default--}}
                                <input type="hidden" name="language_id" value="6">

                                <label class="col-sm-12 control-label" for="name">Project Name (<span
                                            class="red">*</span>)</label>
                                <div class="col-sm-12">
                                    <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                                        <input id="name" type="text" class="form-control" name="name"
                                               value="{{ old('name') ? old('name') : $viewModel->project->name  }}"
                                               required
                                               placeholder="Project Name">
                                        <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-12 control-label" for="description">Project Description (<span
                                            class="red">*</span>)<br>
                                </label>
                                <div class="col-sm-12">
                                    <div class="form-group has-feedback">
                                    <textarea id="description" class="form-control" name="description"
                                              required
                                              placeholder="Project Description">{{ old('description') ? old('description') : $viewModel->project->description }}</textarea>
                                        <span class="help-block"><strong>{{ $errors->first('description') }}</strong></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="status_id">Project status</label>
                                        <select id="status_id" class="form-control" name="status_id">
                                            @foreach ($viewModel->projectStatusesLkp as $status)
                                                <option
                                                        @if ($viewModel->project->status_id == $status->id || old('status_id') == $status->id)
                                                        selected
                                                        @endif
                                                        value="{{ $status->id }}">
                                                    {{ $status->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <br>
                            </div>
                            <div class="row">
                                <label class="col-md-12 control-label" for="slug">Project Slug <br>(it defines the
                                    project's url,
                                    for example:
                                    <i>http://crowdsourcing.scify.org/your-project-slug</i>)<br>
                                    It can contain only letters, numbers, and dashes.<br>
                                    If left empty, we will take care of creating the URL, based on the project name.<br>
                                    Please note that once you publish the project you <i>cannot</i> change the slug.
                                </label>
                                <div class="col-sm-12">

                                    <div class="form-group has-feedback {{ $errors->has('slug') ? 'has-error' : '' }}">
                                        <input id="slug" type="text" class="form-control" name="slug"
                                               value="{{ old('slug') ? old('slug') : $viewModel->project->slug  }}"
                                               placeholder="Project Slug">
                                        <span class="help-block"><strong>{{ $errors->first('slug') }}</strong></span>
                                    </div>

                                </div>
                            </div>
                            <div class="row image-input-container">
                                <label class="col-sm-12 control-label">Project Logo</label>
                                <div class="col-sm-12">
                                    <div class="image-preview-container">
                                        <img class="selected-image-preview"
                                             src="{{asset($viewModel->project->logo_path)}}"
                                             alt="Selected logo image">
                                    </div>
                                    <div class="form-group has-feedback input-file-wrapper">
                                        <small>In order to update the currently selected image, please choose a new
                                            image by
                                            clicking the button below.
                                        </small>
                                        <input type="file" name="logo" class="image-input" accept="image/*">
                                        <span class="help-block"><strong>{{ $errors->first('logo') }}</strong></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-6 col-sm-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h2>Landing Page</h2>
                        </div>
                        <div class="box-body">
                            <div class="row image-input-container">
                                <label class="col-sm-12 control-label">Motto Background Image </label>
                                <div class="col-sm-12">
                                    <div class="image-preview-container">
                                        <img class="selected-image-preview"
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
                                              required
                                              placeholder="Project Motto">{{ old('motto') ? old('motto') : $viewModel->project->motto }}</textarea>
                                        <span class="help-block"><strong>{{ $errors->first('motto') }}</strong></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb">
                                <label class="col-md-12 control-label" for="lp_motto_color">Project Motto color (<span
                                            class="red">*</span>)<br>
                                </label>
                                <div class="col-md-6 col-sm-12">
                                    <div class="input-group colorpicker-component color-picker">
                                        <input id="lp_motto_color" type="text" name="lp_motto_color" class="form-control"
                                               required
                                               value="{{ old('lp_motto_color') ? old('lp_motto_color') :
                                                        $viewModel->project->lp_motto_color  }}"/>
                                        <span class="input-group-addon"><i></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-12 control-label" for="about">About Text (<span
                                            class="red">*</span>)</label>
                                <div class="col-sm-12">
                                    <div class="form-group has-feedback">
                                    <textarea id="about" class="form-control summernote" name="about"
                                              required
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
                                        <input id="lp_about_color" type="text" name="lp_about_color" class="form-control"
                                               required
                                               value="{{ old('lp_about_color') ? old('lp_about_color') :
                                                        $viewModel->project->lp_about_color  }}"/>
                                        <span class="input-group-addon"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb">
                                <label class="col-md-12 control-label" for="lp_about_bg_color">About Text background (<span
                                            class="red">*</span>)<br>
                                </label>
                                <div class="col-md-6 col-sm-12">
                                    <div class="input-group colorpicker-component color-picker">
                                        <input id="lp_about_bg_color" type="text" name="lp_about_bg_color" class="form-control"
                                               required
                                               value="{{ old('lp_about_bg_color') ? old('lp_about_bg_color') :
                                                        $viewModel->project->lp_about_bg_color  }}"/>
                                        <span class="input-group-addon"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-12 control-label" for="footer">Footer Text (<span
                                            class="red">*</span>)</label>
                                <div class="col-sm-12">
                                    <div class="form-group has-feedback">
                                    <textarea id="footer" class="form-control summernote" name="footer"
                                              required
                                              placeholder="Footer Section">{{ old('footer') ? old('footer') : $viewModel->project->footer }}</textarea>
                                        <span class="help-block"><strong>{{ $errors->first('footer') }}</strong></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb">
                                <label class="col-md-12 control-label" for="lp_footer_color">Footer Text color (<span
                                            class="red">*</span>)<br>
                                </label>
                                <div class="col-md-6 col-sm-12">
                                    <div class="input-group colorpicker-component color-picker">
                                        <input id="lp_footer_color" type="text" name="lp_footer_color" class="form-control"
                                               required
                                               value="{{ old('lp_footer_color') ? old('lp_footer_color') :
                                                        $viewModel->project->lp_footer_color  }}"/>
                                        <span class="input-group-addon"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb">
                                <label class="col-md-12 control-label" for="lp_footer_bg_color">Footer Text background (<span
                                            class="red">*</span>)<br>
                                </label>
                                <div class="col-md-6 col-sm-12">
                                    <div class="input-group colorpicker-component color-picker">
                                        <input id="lp_footer_bg_color" type="text" name="lp_footer_bg_color"
                                               class="form-control" required
                                               value="{{ old('lp_footer_bg_color') ? old('lp_footer_bg_color') :
                                                        $viewModel->project->lp_footer_bg_color  }}"/>
                                        <span class="input-group-addon"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <hr/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h2>Active Questionnaire section</h2>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-12 control-label" for="lp_questionnaire_color">Questionnaire color (<span
                                            class="red">*</span>)<br>
                                </label>
                                <div class="col-md-6 col-sm-12">
                                    <div class="input-group colorpicker-component color-picker">
                                        <input id="lp_questionnaire_color" type="text" name="lp_questionnaire_color"
                                               class="form-control" required
                                               value="{{ old('lp_questionnaire_color') ? old('lp_questionnaire_color') :
                                                        $viewModel->project->lp_questionnaire_color  }}"/>
                                        <span class="input-group-addon"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row image-input-container">
                                <label class="col-sm-12 control-label">Questionnaire Background Image </label>
                                <div class="col-sm-12">
                                    <div class="image-preview-container">
                                        <img class="selected-image-preview"
                                             src="{{asset($viewModel->project->lp_questionnaire_img_path)}}"
                                             alt="Selected questionnaire background image">
                                    </div>
                                    <div class="form-group has-feedback input-file-wrapper">
                                        <small>In order to update the currently selected image, please choose a new
                                            image by
                                            clicking the button below.
                                        </small>
                                        <input type="file" name="lp_questionnaire_img" class="image-input" accept="image/*">
                                        <span class="help-block"><strong>{{ $errors->first('lp_questionnaire_img') }}</strong></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h2>Social Media metadata</h2>
                        </div>
                        <div class="box-body">
                            <div class="row image-input-container">
                                <label class="col-sm-12 control-label">Featured Image </label>
                                <div class="col-sm-12">
                                    <div class="image-preview-container">
                                        <img class="selected-image-preview"
                                             src="{{$viewModel->project->sm_featured_img_path ? asset($viewModel->project->sm_featured_img_path) : ''}}"
                                             alt="Social media featured image">
                                    </div>
                                    <div class="form-group has-feedback input-file-wrapper">
                                        <small>In order to update the currently selected image, please choose a new
                                            image by
                                            clicking the button below.
                                        </small>
                                        <input type="file" name="sm_featured_img" class="image-input" accept="image/*">
                                        <span class="help-block"><strong>{{ $errors->first('sm_featured_img') }}</strong></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-12 control-label" for="sm_title">Social Media Title</label>
                                <div class="col-sm-12">
                                    <div class="form-group has-feedback {{ $errors->has('sm_title') ? 'has-error' : '' }}">
                                        <input id="sm_title" type="text" class="form-control" name="sm_title"
                                               value="{{ old('sm_title') ? old('sm_title') : $viewModel->project->sm_title  }}"
                                               placeholder="Enter the title you would like to appear when posting the project to social media">
                                        <span class="help-block"><strong>{{ $errors->first('sm_title') }}</strong></span>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-12 control-label" for="sm_description">Social Media Description<br>
                                </label>
                                <div class="col-md-12">
                                    <div class="form-group has-feedback">
                                        <textarea id="sm_description" class="form-control" name="sm_description"
                                                  placeholder="Enter the description you would like to appear when posting the project to social media">{{ old('sm_description') ? old('sm_description') : trim($viewModel->project->sm_description) }}</textarea>
                                        <span class="help-block"><strong>{{ $errors->first('sm_description') }}</strong></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-12 control-label" for="sm_keywords">Social Media Keywords<br>
                                </label>
                                <p class="col-md-12">Type enter or comma in order to separate the keywords.</p>
                                <div class="col-md-12">
                                    <input type="text" name="sm_keywords" id="sm_keywords" class="form-control"
                                           data-role="tagsinput"
                                           value="{{ old('sm_keywords') ? old('sm_keywords') : $viewModel->project->sm_keywords  }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <button class="btn btn-block btn-primary btn-lg" type="submit">Save</button>
                </div>
            </div>
        </div>
    </form>
@stop

@push('scripts')
    <script src="{{mix('dist/js/manageProject.js')}}"></script>
@endpush
