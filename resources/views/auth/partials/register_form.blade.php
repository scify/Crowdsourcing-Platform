{!! csrf_field() !!}
<div class="form-group has-feedback {{ $errors->has('nickname') ? 'has-error' : '' }}">
    <input type="text" name="nickname" class="form-control" value="{{ old('nickname') }}"
           placeholder="{{ __("login-register.nickname") }}">
    <span class="glyphicon glyphicon-user form-control-feedback"></span>
    @if ($errors->has('nickname'))
        <span class="help-block">
                            <strong>{{ $errors->first('nickname') }}</strong>
                        </span>
    @endif
</div>
<div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
    <input type="email" name="email" class="form-control" value="{{ old('email') }}"
           placeholder="{{ __("login-register.email") }}">
    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    @if ($errors->has('email'))
        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
    @endif
</div>
<div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
    <input type="password" name="password" class="form-control"
           placeholder="{{ __("login-register.password") }}">
    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    @if ($errors->has('password'))
        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
    @endif
</div>
<div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
    <input type="password" name="password_confirmation" class="form-control"
           placeholder="{{ __("login-register.retype_password") }}">
    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
    @if ($errors->has('password_confirmation'))
        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
    @endif
</div>
<div class="form-group ">
    <div class="checkbox icheck">
        <label>
            <input class="icheck-input" type="checkbox" required name="privacy-policy">
            {{-- <span class="ml-3">I agree to the <a href="{{route('terms.privacy')}}" target="_blank">the privacy policy</a></span> --}}
            <span class="ml-3">{!! __("notifications.agree_privacy_policy") !!}</a></span>
        </label>
    </div>
</div>

