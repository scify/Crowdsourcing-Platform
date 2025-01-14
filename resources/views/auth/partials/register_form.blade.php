{!! csrf_field() !!}
<div class="form-group has-feedback {{ $errors->has('nickname') ? 'has-error' : '' }}">
    <label for="nickname" class="sr-only">{{ __("login-register.nickname") }}</label>
    <input type="text" name="nickname" id="nickname" class="form-control mb-1" value="{{ old('nickname') }}"
           placeholder="{{ __("login-register.nickname") }}">
    <span class="glyphicon glyphicon-user form-control-feedback"></span>
    <span class="help-block hidden" id="nickname-help">
        <strong>{{ __('my-account.nickname_help') }}</strong>
    </span>
    @if ($errors->has('nickname'))
        <span class="help-block">
            <strong>{{ $errors->first('nickname') }}</strong>
        </span>
    @endif
</div>
<div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
    <label for="email" class="sr-only">{{ __("login-register.email") }}</label>
    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}"
           placeholder="{{ __("login-register.email") }}">
    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    @if ($errors->has('email'))
        <span class="help-block">
            <strong>{{ $errors->first('email') }}</strong>
        </span>
    @endif
</div>
<div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
    <label for="password" class="sr-only">{{ __("login-register.password") }}</label>
    <input type="password" name="password" id="password" class="form-control"
           placeholder="{{ __("login-register.password") }}">
    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    @if ($errors->has('password'))
        <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
    @endif
</div>
<div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
    <label for="retype-password" class="sr-only">{{ __("login-register.retype_password") }}</label>
    <input type="password" name="password_confirmation" id="retype-password" class="form-control"
           placeholder="{{ __("login-register.retype_password") }}">
    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
    @if ($errors->has('password_confirmation'))
        <span class="help-block">
            <strong>{{ $errors->first('password_confirmation') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    <label for="gender" class="sr-only">{{ __("login-register.gender") }}</label>
    <select id="gender" name="gender" class="form-control">
        <option value="">{{ __("login-register.gender") }}</option>
        @foreach ($viewModel['availableGenders'] as $genderKey => $genderValue)
            <option
                    @if (old('gender') == $genderKey)
                        selected
                    @endif
                    value="{{ $genderKey }}"
            >
                {{ $genderValue }}
            </option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="country" class="sr-only">{{ __("login-register.country") }}</label>
    <select id="country" name="country" class="form-control">
        <option value="">{{ __("login-register.country") }}</option>
        @foreach ($viewModel['availableCountries'] as $countryKey => $countryValue)
            <option
                    @if (old('country') == $countryKey)
                        selected
                    @endif
                    value="{{ $countryKey }}"
            >
                {{ $countryValue }}
            </option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="year-of-birth" class="sr-only">{{ __("login-register.year_of_birth") }}</label>
    <select id="year-of-birth" name="year-of-birth" class="form-control">
        <option value="">{{ __("login-register.year_of_birth") }}</option>
        @foreach ($viewModel['availableYearsOfBirth'] as $year)
            <option
                    @if (old('year-of-birth') == $year)
                        selected
                    @endif
                    value="{{ $year }}"
            >
                {{ $year }}
            </option>
        @endforeach
    </select>
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

