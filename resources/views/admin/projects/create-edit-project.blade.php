@extends('loggedin-environment.layout')

@section('content-header')
    <h1>{{ $viewModel->isEditMode() ? 'Edit' : 'Create' }} Project {{ $viewModel->isEditMode() ? ': ' . $viewModel->project->name : '' }}</h1>
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('dist/css/create-edit-project.css') }}">
@endpush

@section('content')
    <div class="container-fluid no-padding">
        <div class="row">
            <div class="col-lg-10 col-md-11 col-xs-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h2>Project Details</h2>
                        <p class="margin-top">required fields are marked with (<span class="red">*</span>)</p>
                    </div>
                    <form id="project-form" enctype="multipart/form-data" role="form" method="POST"
                          action="{{ $viewModel->isEditMode() ? route('projects.update', $viewModel->project) : route('projects.store') }}">
                        @if($viewModel->isEditMode())
                            @method('PUT')
                        @endif
                        <div class="box-body">
                            <div class="row">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                {{--English by default--}}
                                <input type="hidden" name="language_id" value="6">

                                <label class="col-sm-12 control-label">Project Name (<span class="red">*</span>)</label>
                                <div class="col-sm-12">
                                    <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                                        <input id="name" type="text" class="form-control" name="name"
                                               value="{{ old('name') ? old('name') : $viewModel->project->name  }}"
                                               required
                                               placeholder="Project Name">
                                        <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                                    </div>

                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Project status</label>
                                        <select class="form-control" name="status_id">
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
                                
                                <label class="col-sm-12 control-label">Project Slug <br>(it defines the project's url,
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


                                <label class="col-sm-12 control-label">Project Motto (<span
                                            class="red">*</span>)</label>
                                <div class="col-sm-12">
                                    <div class="form-group has-feedback">
                                    <textarea id="motto" class="form-control" name="motto"
                                              required
                                              placeholder="Project Motto">{{ old('motto') ? old('motto') : $viewModel->project->motto }}</textarea>
                                        <span class="help-block"><strong>{{ $errors->first('motto') }}</strong></span>
                                    </div>
                                </div>

                                <label class="col-sm-12 control-label">Project Description (<span
                                            class="red">*</span>)<br>
                                    <i>(this will be used when posting the project's URL to social media)</i>
                                </label>
                                <div class="col-sm-12">
                                    <div class="form-group has-feedback">
                                    <textarea id="description" class="form-control" name="description"
                                              required
                                              placeholder="Project Description">{{ old('description') ? old('description') : $viewModel->project->description }}</textarea>
                                        <span class="help-block"><strong>{{ $errors->first('description') }}</strong></span>
                                    </div>
                                </div>

                                <span class="help-block"><strong>{{ $errors->first('motto') }}</strong></span>

                                <label class="col-sm-12 control-label">About Text (<span class="red">*</span>)</label>
                                <div class="col-sm-12">
                                    <div class="form-group has-feedback">
                                    <textarea id="about" class="form-control summernote" name="about"
                                              required
                                              placeholder="About Text">{{ old('about') ? old('about') : $viewModel->project->about }}</textarea>
                                        <span class="help-block"><strong>{{ $errors->first('about') }}</strong></span>
                                    </div>
                                </div>


                                <label class="col-sm-12 control-label">Footer Section (<span
                                            class="red">*</span>)</label>
                                <div class="col-sm-12">
                                    <div class="form-group has-feedback">
                                    <textarea id="footer" class="form-control summernote" name="footer"
                                              required
                                              placeholder="Footer Section">{{ old('footer') ? old('footer') : $viewModel->project->footer }}</textarea>
                                        <span class="help-block"><strong>{{ $errors->first('footer') }}</strong></span>
                                    </div>
                                </div>


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
                                        <input type="file" name="logo" accept="image/*">
                                        <span class="help-block"><strong>{{ $errors->first('logo') }}</strong></span>
                                    </div>
                                </div>


                                <label class="col-sm-12 control-label">Motto Background Image </label>
                                <div class="col-sm-12">
                                    <div class="image-preview-container">
                                        <img class="selected-image-preview"
                                             src="{{asset($viewModel->project->img_path)}}"
                                             alt="Selected motto background image">
                                    </div>
                                    <div class="form-group has-feedback input-file-wrapper">
                                        <small>In order to update the currently selected image, please choose a new
                                            image by
                                            clicking the button below.
                                        </small>
                                        <input type="file" name="img" accept="image/*">
                                        <span class="help-block"><strong>{{ $errors->first('img') }}</strong></span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-3 col-sm-12 no-padding">
                                        <button class="btn btn-block btn-primary btn-lg" type="submit">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script src="{{mix('dist/js/manageProject.js')}}"></script>
@endpush
