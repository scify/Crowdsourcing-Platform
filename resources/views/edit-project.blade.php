@extends('loggedin-environment.layout')

@section('content-header')
    <h1>Edit Project</h1>
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('dist/css/edit-project.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Project Details</h3>
                </div>
                <form id="form-change-password" enctype="multipart/form-data" role="form" method="POST"
                      action="{{ url("/project/$project->id/update") }}">
                    <div class="box-body">
                        <div class="row">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            {{--English by default--}}
                            <input type="hidden" name="language_id" value="6">

                            <label class="col-sm-12 control-label">Project Name</label>
                            <div class="col-sm-12">
                                <div class="form-group has-feedback">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{ $project->name  }}"
                                           required
                                           placeholder="Project Name">
                                </div>
                            </div>
                            <span class="form-control-feedback"></span>

                            <label class="col-sm-12 control-label">Project Motto</label>
                            <div class="col-sm-12">
                                <div class="form-group has-feedback">
                                    <textarea id="motto" class="form-control" name="motto"
                                              required
                                              placeholder="Project Motto">{{ $project->motto }}</textarea>
                                </div>
                            </div>
                            <span class="form-control-feedback"></span>

                            <label class="col-sm-12 control-label">About Text</label>
                            <div class="col-sm-12">
                                <div class="form-group has-feedback">
                                    <textarea id="about" class="form-control summernote" name="about"
                                              required
                                              placeholder="About Text">{{ $project->about }}</textarea>
                                </div>
                            </div>
                            <span class="form-control-feedback"></span>

                            <label class="col-sm-12 control-label">Footer Section</label>
                            <div class="col-sm-12">
                                <div class="form-group has-feedback">
                                    <textarea id="footer" class="form-control summernote" name="footer"
                                              required
                                              placeholder="Footer Section">{{ $project->footer }}</textarea>
                                </div>
                            </div>
                            <span class="form-control-feedback"></span>

                            <label class="col-sm-12 control-label">Project Logo</label>
                            <div class="col-sm-12">
                                <div class="image-preview-container">
                                    <img class="selected-image-preview" src="{{asset($project->logo_path)}}"
                                         alt="Selected logo image">
                                </div>
                                <div class="form-group has-feedback input-file-wrapper">
                                    <small>In order to update the currently selected image, please choose a new image by
                                        clicking the button below.
                                    </small>
                                    <input type="file" name="logo" accept="image/*">
                                </div>
                            </div>
                            <span class="form-control-feedback"></span>

                            <label class="col-sm-12 control-label">Motto Background Image</label>
                            <div class="col-sm-12">
                                <div class="image-preview-container">
                                    <img class="selected-image-preview" src="{{asset($project->img_path)}}"
                                         alt="Selected motto background image">
                                </div>
                                <div class="form-group has-feedback input-file-wrapper">
                                    <small>In order to update the currently selected image, please choose a new image by
                                        clicking the button below.
                                    </small>
                                    <input type="file" name="img" accept="image/*">
                                </div>
                            </div>
                            <span class="form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-4 col-sm-offset-4">
                                <button class="btn btn-block btn-primary" type="submit">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script src="{{mix('dist/js/manageProject.js')}}"></script>
@endpush