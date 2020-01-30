{!! csrf_field() !!}
<div class="form-group has-feedback {{ $errors->has('nickname') ? 'has-error' : '' }}">
    <input type="text" name="nickname" class="form-control" value="{{ old('nickname') }}"
           placeholder="Nickname">
    <span class="glyphicon glyphicon-user form-control-feedback"></span>
    @if ($errors->has('nickname'))
        <span class="help-block">
                            <strong>{{ $errors->first('nickname') }}</strong>
                        </span>
    @endif
</div>
<div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
    <input type="email" name="email" class="form-control" value="{{ old('email') }}"
           placeholder="Email">
    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    @if ($errors->has('email'))
        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
    @endif
</div>
<div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
    <input type="password" name="password" class="form-control"
           placeholder="Password">
    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    @if ($errors->has('password'))
        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
    @endif
</div>
<div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
    <input type="password" name="password_confirmation" class="form-control"
           placeholder="Retype Password">
    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
    @if ($errors->has('password_confirmation'))
        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
    @endif
</div>
