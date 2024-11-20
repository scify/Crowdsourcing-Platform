@extends('backoffice.layout')

@section('title', 'home')

@section('content-header')
    <h1>Manage Users</h1>
@endsection

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Edit platform users</h3>
        </div>
        <div class="card-body">
            <div id="allUsers">
                @include('backoffice.management.partials.user-filters')
                @include('backoffice.management.partials.users-list', ['users' => $viewModel->users])
            </div>
        </div>
    </div>

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Add new user</h3>
        </div>
        <div class="card-body">
            @include('backoffice.management.partials.new-user-form', ['roles' => $viewModel->allRoles])
        </div>
    </div>
@endsection
@push('scripts')
    @vite('resources/assets/js/pages/manage-users.js')
@endpush
