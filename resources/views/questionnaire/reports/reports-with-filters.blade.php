@extends('loggedin-environment.layout')

@section('content-header')
    <h1>Reports</h1>
@stop

@push('css')
    <link rel="stylesheet" type="text/css" href="{{mix('dist/css/reports.css')}}">
@endpush

@section('content')
    <div class="row reports">
        <div class="col-md-12 col-xs-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Crowdsourcing Projects Reports</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9 col-sm-12">
                            <p>Select Questionnaire:</p>
                            <select class="form-control" name="questionnaire_id">
                                @foreach ($viewModel->allQuestionnaires as $questionnaire)
                                    <option value="{{ $questionnaire->id }}">
                                        {{ $questionnaire->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-12 justify-content-center align-items-center">
                            <button id="searchBtn" class="btn btn-block btn-primary search-btn btn-lg" data-url="{{ route('questionnaireReport') }}"><i
                                        class="fa fa-plus mr-1"></i> View</button>
                        </div>
                    </div>
                    <div id="errorMsg" class="alert alert-danger stickyAlert margin-top margin-bottom d-none" role="alert"></div>
                </div>
            </div>
            <div class="row loader-container">
                <div class="col-md-12">
                    <div class="loader d-none fa-3x" id="loader">
                        <i class="fas fa-sync fa-spin"></i>
                    </div>
                </div>
            </div>
            <div id="results"></div>
        </div>
    </div>
@stop
@push('modals')
    <div class="modal fade" id="answersModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Question: "<span id="questionTitle"></span>"</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <table id="answerTextsTable" class="display w-100 table table-striped table-bordered" width="100%"></table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
                </div>
            </div>
        </div>
    </div>
@endpush
@push('scripts')
    <script src="{{mix('dist/js/reports.js')}}"></script>
@endpush
