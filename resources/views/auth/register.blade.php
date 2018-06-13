@extends('auth.layout')

@push('css')
    <link rel="stylesheet" href="{{ asset('dist/css/register.css') }}">
@endpush

@section('auth-form')
    <p class="login-box-msg">@lang('register.select_account_type')</p>
    <a class="reselect-account-type" href="javascript:void(0)"><i class="fa fa-angle-left"></i> @lang('register.reselect_account_type')</a>
    <div class="row">
        <div class="col-md-6">
            <button class="btn btn-primary btn-block btn-flat text-center account-type-btn"
                    data-target=".journalist-form-wrapper">
                <img src="{{asset('images/icons/video-camera.png')}}">
                <p>I am a journalist</p>
            </button>
        </div>
        <div class="col-md-6">
            <button class="btn btn-primary btn-block btn-flat text-center account-type-btn"
                    data-target=".publisher-form-wrapper">
                <img src="{{asset('images/icons/van.png')}}">
                <p>I am a publisher</p>
            </button>
        </div>
    </div>
    <span class="role-after-validation-fail" data-role="{{ old('role') }}"></span>
    <div class="journalist-form-wrapper form-wrapper">
        <p class="welcome-msg">Welcome new journalist!</p>
        <form action="{{ url(config('adminlte.register_url', 'register')) }}" method="post">
            @include('partials.register_form', ['role' => 'journalist'])
            <button type="submit"
                    class="btn btn-primary btn-block btn-flat"
            >{{ trans('adminlte::adminlte.register') }}</button>
        </form>
    </div>
    <div class="publisher-form-wrapper form-wrapper">
        <p class="welcome-msg">Welcome new publisher!</p>
        <form action="{{ url(config('adminlte.register_url', 'register')) }}" method="post" enctype="multipart/form-data">
            @include('partials.register_form', ['role' => 'publisher'])

            <div class="form-group">
                Your CMS configuration:
            </div>
            <div class="form-group has-feedback {{ $errors->has('cms_name') ? 'has-error' : '' }}">
                <input type="text" name="cms_name" class="form-control" value="{{ old('cms_name') }}"
                       placeholder="CMS name">
                <span class="glyphicon glyphicon-home form-control-feedback"></span>
                @if ($errors->has('cms_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('cms_name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('cms') ? 'has-error' : '' }}">
                <input type="text" name="cms" class="form-control" value="{{ old('cms') }}"
                       placeholder="CMS domain name (XXX.cpinng.com)">
                <span class="glyphicon glyphicon-globe form-control-feedback"></span>
                @if ($errors->has('cms'))
                    <span class="help-block">
                        <strong>{{ $errors->first('cms') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('logo') ? 'has-error' : '' }}">
                <p class="help-block">Upload an image file to be used as your CMS logo.</p>
                <input id="logo-upload" type="file" name="logo" class="" value="{{ old('logo') }}" accept="image/*">
                @if ($errors->has('logo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('logo') }}</strong>
                    </span>
                @endif

            </div>
            <button type="submit"
                    class="btn btn-primary btn-block btn-flat"
            >{{ trans('adminlte::adminlte.register') }}</button>
        </form>
    </div>
    <div class="auth-links">
        <a href="{{ url(config('adminlte.login_url', 'login')) }}"
           class="text-center">{{ trans('adminlte::adminlte.i_already_have_a_membership') }}</a>
    </div>
@stop
@push('scripts')
    <script src="{{ asset('dist/js/register.js') }}"></script>
@endpush