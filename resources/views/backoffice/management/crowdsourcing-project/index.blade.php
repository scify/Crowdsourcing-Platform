@extends('backoffice.layout')
@section('title', 'home')
@section('content-header')
    <h1>All Crowd-sourcing Projects</h1>
@endsection

@push('css')
    @vite('resources/assets/sass/project/all-projects.scss')
@endpush

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Edit projects</h3>
        </div>
        <div class="card-body">
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
                                {{ $project->defaultTranslation->name }}
                            </td>
                            <td>
                                <img loading="lazy" class="project-logo" src="{{ $project->logo_path }}"
                                     alt="{{ $project->defaultTranslation->name }} logo">
                            </td>
                            <td>
                                <span class="badge {{$viewModel->getProjectStatusCSSClass($project->status)}}">{{$project->status->title}}</span>
                            </td>
                            <td>
                                {{ $project->creator->nickname }}
                            </td>
                            <td>
                                {{ $project->language->language_name }}
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-slimmer dropdown-toggle" type="button"
                                            data-toggle="dropdown">Select an action
                                        <span class="caret"></span></button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                           href="{{ route('projects.edit', $project->id) }}">Edit</a>
                                        <a class="dropdown-item"
                                           href="{{ route('project.clone', $project->id) }}">Clone</a>
                                        <a class="dropdown-item"
                                           href="{{ route('project.landing-page', $project->slug) }}">View Landing
                                            Page</a>
                                        <a class="dropdown-item" href="{{ route('questionnaires.reports') }}">View
                                            Reports</a>
                                    </div>
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
