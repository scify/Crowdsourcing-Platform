@extends('loggedin-environment.layout')
@section('title', 'home')
@section('content-header')
    <h1>All Crowd-sourcing Projects</h1>
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('dist/css/all-projects.css') }}">
@endpush

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Edit projects</h3>
        </div>
        <div class="box-body">
            <div class="all-projects">
                <table id="userListTable" class="table table-hover" cellspacing="0" style="width: 100%;">
                    <thead>
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Logo
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Creator
                        </th>
                        <th>
                            Language
                        </th>
                        <th>
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($viewModel->projects as $project)
                            <tr>
                                <td>
                                    {{ $project->id }}
                                </td>
                                <td>
                                    {{ $project->name }}
                                </td>
                                <td>
                                    <img class="project-logo" src="{{ $project->logo_path }}" alt="{{ $project->name }} logo">
                                </td>
                                <td class="status {{ $viewModel->getProjectStatusCSSClass($project->status) }}">
                                    {{ $project->status->title }}
                                </td>
                                <td>
                                    {{ $project->creator->nickname }}
                                </td>
                                <td>
                                    {{ $project->language->language_name }}
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select an action
                                            <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{ route('projects.edit', $project->id) }}">Edit Project</a></li>
                                            <li><a href="{{ route('project.landing-page', $project->slug) }}">View Landing Page</a></li>
                                            <li><a href="{{ route('project.reports', $project->id) }}">View Reports</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
