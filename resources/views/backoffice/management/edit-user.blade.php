@extends('backoffice.layout')
@section('title', 'home')
@section('content-header')
    <h1>Edit User</h1>
@endsection

@section('content')
    <form action="{{ url('backoffice/update-user') }}" method="POST">
        {{ csrf_field() }}
        <input name="userId" type="hidden" value="{{ $viewModel->user->id }}">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Edit user {{ $viewModel->user->nickname }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group has-feedback">
                            <label for="email">Email</label>
                            <input id="email" type="text" class="form-control" name="email"
                                   value="{{ $viewModel->user->email }}"
                                   required
                                   autofocus placeholder="Email" readonly>
                            @if ($errors->has('email'))
                                <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                            @endif
                        </div>

                        <div class="form-group has-feedback">
                            <label for="nickname">Nickname</label>
                            <input id="nickname" type="text" class="form-control" name="nickname"
                                   value="{{ $viewModel->user->nickname  }}"
                                   required
                                   autofocus
                                   placeholder="Nickname" readonly>
                            <span class="form-control-feedback"></span>
                            @if ($errors->has('nickname'))
                                <span class="help-block">
                            <strong>{{ $errors->first('nickname') }}</strong>
                        </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="rolesselect">User roles</label>
                            <select class="form-control" name="roleselect[]" id="rolesselect">
                                @foreach ($viewModel->allRoles as $role)
                                    <option
                                            @if ($viewModel->userRoleIds->contains($role->id))
                                                selected
                                            @endif
                                            value="{{ $role->id }}" name="roleVal[{{ $role->id }}]"
                                    >
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                                <option value="" name="">REMOVE ALL ROLES</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="gender">{{ __("login-register.gender") }}</label>
                            <select class="form-control" name="gender" id="gender">
                                <option value="">{{ __("login-register.gender") }}</option>
                                @foreach ($viewModel->availableGenders as $gender)
                                    <option
                                            @if (old('gender') == $gender->value)
                                                selected
                                            @elseif ($viewModel->user->gender == $gender->value)
                                                selected
                                            @endif
                                            value="{{ $gender->value }}"
                                    >
                                        {{ __('common.' . $gender->value) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="country">{{ __("login-register.country") }}</label>
                            <select class="form-control" name="country" id="country">
                                <option value="">{{ __("login-register.country") }}</option>
                                @foreach ($viewModel->availableCountries as $country)
                                    <option
                                            @if (old('country') == $country->name)
                                                selected
                                            @elseif ($viewModel->user->country == $country->name)
                                                selected
                                            @endif
                                            value="{{ $country->name }}"
                                    >
                                        {{ $country->value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="year-of-birth">{{ __("login-register.year_of_birth") }}</label>
                            <select class="form-control" name="year-of-birth" id="year-of-birth">
                                <option value="">{{ __("login-register.year_of_birth") }}</option>
                                @foreach ($viewModel->availableYearsOfBirth as $year)
                                    <option
                                            @if (old('year-of-birth') == $year)
                                                selected
                                            @elseif ($viewModel->user->year_of_birth == $year)
                                                selected
                                            @endif
                                            value="{{ $year }}"
                                    >
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <button type="submit" class="btn btn-block btn-primary btn-lg">Update user info</button>
            </div>
        </div>
    </form>
@endsection
