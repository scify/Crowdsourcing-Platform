@extends('loggedin-environment.layout')

@section('content-header')
    <h1>{{ $viewModel->isEditMode() ? 'Edit' : 'Create' }}
        Project {{ $viewModel->isEditMode() ? ': ' . $viewModel->project->name : '' }}
        <small class="font-weight-light">(required fields are marked with <span class="red">*</span>)</small></h1>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ mix('dist/css/create-edit-project.css') }}">
@endpush

@section('content')
    <form id="project-form" enctype="multipart/form-data" role="form" method="POST"
          action="{{ $viewModel->isEditMode() ? route('projects.update', $viewModel->project) : route('projects.store') }}">
        @if($viewModel->isEditMode())
            @method('PUT')
        @endif
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-md-10 col-sm-12 mx-auto">
                    <div class="bs-stepper" id="project-form-stepper">
                        <div class="bs-stepper-header" role="tablist">
                            <div class="step" data-target="#basic-details">
                                <button type="button" class="step-trigger" role="tab" aria-controls="basic-details"
                                        id="basic-details-trigger">
                                    <span class="bs-stepper-circle">1</span>
                                    <span class="bs-stepper-label">Basic Details</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#landing-page">
                                <button type="button" class="step-trigger" role="tab" aria-controls="landing-page"
                                        id="landing-page-trigger">
                                    <span class="bs-stepper-circle">2</span>
                                    <span class="bs-stepper-label">Landing Page</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#social-media">
                                <button type="button" class="step-trigger" role="tab" aria-controls="social-media"
                                        id="social-media-trigger">
                                    <span class="bs-stepper-circle">3</span>
                                    <span class="bs-stepper-label">Social Media</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#communication-resources">
                                <button type="button" class="step-trigger" role="tab"
                                        aria-controls="communication-resources"
                                        id="communication-resources-trigger">
                                    <span class="bs-stepper-circle">4</span>
                                    <span class="bs-stepper-label">Communication Emails</span>
                                </button>
                            </div>
                        </div>
                        <div class="bs-stepper-content">
                            <div id="basic-details" class="content" role="tabpanel"
                                 aria-labelledby="basic-details-trigger">
                                @include('admin.projects.create-edit.partials.basic-details')
                            </div>
                            <div id="landing-page" class="content" role="tabpanel"
                                 aria-labelledby="landing-page-trigger">
                                @include('admin.projects.create-edit.partials.landing-page')
                            </div>
                            <div id="social-media" class="content" role="tabpanel"
                                 aria-labelledby="social-media-trigger">
                                @include('admin.projects.create-edit.partials.social-media')
                            </div>
                            <div id="communication-resources" class="content" role="tabpanel"
                                 aria-labelledby="communication-resources-trigger">
                                @include('admin.projects.create-edit.partials.communication-resources')
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-5 col-sm-12 mx-auto">
                                <div class="container-fluid">
                                    <div class="row mb-2">
                                        <div class="col-6 offset-6">
                                            <div id="form-error-message" class="d-none">Please check all required
                                                fields
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12 mb-3">
                                            <button class="btn btn-block btn-primary btn-lg stepper-previous mb-2"
                                                    type="button">
                                                Previous
                                            </button>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <button class="btn btn-block btn-primary btn-lg stepper-next" type="button">
                                                Next
                                            </button>
                                            <button class="btn btn-block btn-primary btn-lg d-none mt-0"
                                                    id="submit-form"
                                                    type="submit">Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script type="application/javascript" src="{{mix('dist/js/manageProject.js')}}"></script>
@endpush
