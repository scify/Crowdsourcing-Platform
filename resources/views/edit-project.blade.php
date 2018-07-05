@extends('loggedin-environment.layout')

@section('content-header')
    <h1>Edit Project</h1>
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('dist/css/my-profile.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Personal Details</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <form id="form-change-password" role="form" method="POST" action="{{ url('/user/update') }}"
                              novalidate>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">


                            <label class="col-sm-4 control-label">Project Name</label>
                            <div class="col-sm-8">
                                <div class="form-group has-feedback">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{ $project->name  }}"
                                           required
                                           autofocus
                                           placeholder="Name">
                                </div>
                            </div>
                            <span class="form-control-feedback"></span>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script src="{{ mix('dist/js/myProfile.js')}}?{{env("APP_VERSION")}}"></script>
@endpush