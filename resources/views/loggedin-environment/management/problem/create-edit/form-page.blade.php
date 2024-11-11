@extends('loggedin-environment.layout')

@section('content-header')
    <h1>{{ $viewModel->isEditMode() ? 'Edit' : 'Create' }}
        Problem {{ $viewModel->isEditMode() ? ': ' . $viewModel->problem->defaultTranslation->name : '' }}
        <small class="font-weight-light">(required fields are marked with <span class="red">*</span>)</small></h1>
@endsection

@push('css')
    @vite('resources/assets/sass/project/problem/create-edit-problem.scss')
@endpush

@section('content')

    <form id="problem-form" enctype="multipart/form-data"{{-- bookmark2 - enctype? --}} method="POST"
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
            </ul>
            <div class="tab-content " id="myTabContent">
                <div class="tab-pane fade show active " id="basic-details" role="tabpanel"
                     aria-labelledby="basic-details-tab">
                    @include('loggedin-environment.management.problem.create-edit.partials.basic-details')

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
