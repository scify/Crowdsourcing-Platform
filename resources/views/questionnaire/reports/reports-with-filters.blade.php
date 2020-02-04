@extends('loggedin-environment.layout')

@section('content-header')
    <h1>Reports</h1>
@stop

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('dist/css/reports.css')}}">
@endpush

@section('content')
    <div class="row reports">
        <div class="col-md-12 col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Crowdsourcing Projects Reports</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-5">
                            <p>Select Project:</p>
                            <select class="form-control" name="project_id">
                                @foreach ($viewModel->allProjects as $project)
                                    <option value="{{ $project->id }}" >
                                        {{ $project->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <p>Select Questionnaire:</p>
                            <select class="form-control" name="questionnaire_id">
                                @foreach ($viewModel->allQuestionnaires as $questionnaire)
                                    <option value="{{ $questionnaire->id }}">
                                        {{ $questionnaire->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button id="searchBtn" class="btn btn-block btn-primary search-btn" data-url="{{ route('questionnaireReport') }}"><i
                                        class="fa fa-plus margin-r-5"></i> View</button>
                        </div>
                    </div>
                    <div id="errorMsg" class="alert alert-danger stickyAlert margin-top margin-bottom hidden" role="alert"></div>



                </div>

            </div>
            <div class="row loader-container hidden">
                <div class="col-md-12">
                    <div class="loader">
                        <i class="fa fa-refresh fa-spin"></i>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Question: "<span id="questionTitle"></span>"</h4>
                </div>
                <div class="modal-body">
                    <table id="answerTextsTable" class="display" width="100%"></table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
                </div>
            </div>
        </div>
    </div>
@endpush
@push('scripts')
{{--  todo: find nmp alternatives for these  <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>--}}
    <script src="{{mix('dist/js/reports.js')}}"></script>

@endpush
