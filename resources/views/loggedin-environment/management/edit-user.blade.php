@extends('loggedin-environment.layout')
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
