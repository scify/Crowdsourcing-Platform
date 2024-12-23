@extends('backoffice.layout')

@section('content-header')
    <h1>{{ $viewModel->isEditMode() ? 'Edit' : 'Create' }}
        Problem {{ $viewModel->isEditMode() ? ': ' . $viewModel->problem->defaultTranslation->name : '' }}
        <small class="font-weight-light">(required fields are marked with <span class="red">*</span>)</small></h1>
@endsection

@push('css')
    @vite('resources/assets/sass/problem/create-edit-problem.scss')
@endpush

@section('content')

    <form id="problem-form" enctype="multipart/form-data" method="POST"
          action="{{ $viewModel->isEditMode() ? route('problems.update', $viewModel->problem) : route('problems.store') }}">

        @if($viewModel->isEditMode())
            @method('PUT')
        @endif

        @csrf

        <div class="container-fluid p-0">
            <ul class="nav nav-tabs mt-4" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="basic-details-tab" data-toggle="tab" href="#basic-details" role="tab"
                       aria-controls="basic-details" aria-selected="true">Basic Details</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="translations-tab" data-toggle="tab" href="#translations" role="tab"
                       aria-controls="translations" aria-selected="false">Translations</a>
                </li>
            </ul>
            <div class="tab-content " id="myTabContent">
                <div class="tab-pane fade show active " id="basic-details" role="tabpanel"
                     aria-labelledby="basic-details-tab">
                    @include('backoffice.management.problem.create-edit.partials.basic-details')

                </div>
                <div class="tab-pane fade " id="translations" role="tabpanel" aria-labelledby="translations-tab">
                    @include('backoffice.management.problem.create-edit.partials.translations')
                </div>
            </div>
            <div>
                <div class="container-fluid p-0">
                    <div class="row p-0">
                        <div class="col-lg-2 col-md-3 col-sm-12">
                            <input class="btn btn-primary btn-slim w-100 mb-3"
                                   id="submit-form"
                                   type="submit" value="Save">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('scripts')
    @vite('resources/assets/js/problem/manage-problem.js')
@endpush
