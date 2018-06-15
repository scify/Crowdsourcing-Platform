@extends('layouts.main-layout')
@section('title', 'home')
@section('content-header')
    <h1>Edit User</h1>
@stop

@section('content')
    <form action="{{ url('admin/update-user') }}" method="POST">
        {{ csrf_field() }}
        <input name="userId" type="hidden" value="{{ $viewModel->user->id }}">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit user {{ $viewModel->user->name . " " . $viewModel->user->surname }}</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group has-feedback">
                            <label>User name</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{ $viewModel->user->name  }}"
                                   required
                                   autofocus
                                   placeholder="Name" readonly>
                            <span class="form-control-feedback"></span>
                            @if ($errors->has('name'))
                                <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                            @endif
                        </div>

                        <div class="form-group has-feedback">
                            <label>Surname</label>
                            <input id="surname" type="text" class="form-control" name="surname"
                                   value="{{ $viewModel->user->surname}}"
                                   required
                                   autofocus placeholder="Surname" readonly>
                            @if ($errors->has('surname'))
                                <span class="help-block">
                            <strong>{{ $errors->first('surname') }}</strong>
                        </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>User roles</label>
                            <select class="form-control" name="roleselect">
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

                        <div class="form-group has-feedback">
                            <label>Email</label>
                            <input id="email" type="text" class="form-control" name="email" value="{{ $viewModel->user->email }}"
                                   required
                                   autofocus placeholder="Email" readonly>
                            @if ($errors->has('email'))
                                <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                            @endif
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
@stop