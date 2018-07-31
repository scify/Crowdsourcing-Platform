@extends('loggedin-environment.layout')

@section('title', 'home')

@section('content-header')
    <h1>Manage Users</h1>
@stop

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Edit platform users</h3>
        </div>
        <div class="box-body">
            <div id="allUsers">
                @include('admin.partials.user-filters')
                @include('admin.partials.users-list', ['users' => $viewModel->users])
            </div>
        </div>
    </div>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Add new user</h3>
        </div>
        <div class="box-body">
            @include('admin.partials.new-user-form', ['roles' => $viewModel->allRoles])
        </div>
    </div>
@stop
@push('scripts')
    <script src="{{ mix('dist/js/UsersListController.js')}}?{{env("APP_VERSION")}}"></script>
    <script>
        $( document ).ready(function() {
            let controller = new window.UsersListController();
            controller.init();
        });
    </script>
@endpush