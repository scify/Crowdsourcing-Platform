@extends('loggedin-environment.layout')

@section('content-header')
    <h1>{{ $viewModel->isEditMode() ? 'Edit' : 'Create' }}
        Project {{ $viewModel->isEditMode() ? ': ' . $viewModel->project->defaultTranslation->name : '' }}
        <small class="font-weight-light">(required fields are marked with <span class="red">*</span>)</small></h1>
@endsection

@push('css')
    @vite('resources/assets/sass/project/create-edit-project.scss')
@endpush

@section('content')
    <form id="project-form" enctype="multipart/form-data" role="form" method="POST"
          action="{{ $viewModel->isEditMode() ? route('projects.update', $viewModel->project) : route('projects.store') }}">
        @if($viewModel->isEditMode())
            @method('PUT')
        @endif
        <div class="container-fluid p-0">
            <ul class="nav nav-tabs mt-4" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="basic-details-tab" data-toggle="tab" href="#basic-details" role="tab"
                       aria-controls="basic-details" aria-selected="true">Basic Details</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="landing-page-tab" data-toggle="tab" href="#landing-page" role="tab"
                       aria-controls="profile" aria-selected="false">Landing Page</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="social-media-tab" data-toggle="tab" href="#social-media" role="tab"
                       aria-controls="contact" aria-selected="false">Social Media</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="communication-tab" data-toggle="tab" href="#communication-resources" role="tab"
                       aria-controls="contact" aria-selected="false">Communication Emails</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="statistics-colors-tab" data-toggle="tab" href="#statistics-colors" role="tab"
                       aria-controls="contact" aria-selected="false">Statistics Colors</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="translations-tab" data-toggle="tab" href="#translations" role="tab"
                       aria-controls="contact" aria-selected="false">Translations</a>
                </li>
            </ul>
            <div class="tab-content " id="myTabContent">
                <div class="tab-pane fade show active " id="basic-details" role="tabpanel"
                     aria-labelledby="basic-details-tab">
                    @include('admin.projects.create-edit.partials.basic-details')

                </div>
                <div class="tab-pane fade " id="landing-page" role="tabpanel" aria-labelledby="landing-page-tab">
                    @include('admin.projects.create-edit.partials.landing-page')

                </div>
                <div class="tab-pane fade " id="social-media" role="tabpanel" aria-labelledby="social-media-tab">
                    @include('admin.projects.create-edit.partials.social-media')

                </div>
                <div class="tab-pane fade " id="communication-resources" role="tabpanel"
                     aria-labelledby="communication-resources-tab">
                    @include('admin.projects.create-edit.partials.communication-resources')

                </div>
                <div class="tab-pane fade " id="statistics-colors" role="tabpanel"
                     aria-labelledby="statistics-colors-tab">
                    @include('admin.projects.create-edit.partials.statistics-colors')

                </div>
                <div class="tab-pane fade " id="translations" role="tabpanel" aria-labelledby="translations-tab">
                    @include('admin.projects.create-edit.partials.translations')
                </div>
            </div>
            <div>
                <input class="btn btn-primary btn-lg  mt-3 mb-3"
                       id="submit-form"
                       type="submit" value="Save">
            </div>


        </div>
    </form>
@endsection

@push('scripts')
    @vite('resources/assets/js/project/manage-project.js')
@endpush
