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
                <div class="box-header with-border">
                    <h3 class="box-title">Crowdsourcing Projects Reports</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-5">
                            <p>Select Project:</p>
                            <select class="form-control" name="projects">
                                @foreach ($viewModel->allProjects as $project)
                                    <option value="{{ $project->id }}" name="projectId">
                                        {{ $project->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <p>Select Questionnaire:</p>
                            <select class="form-control" name="questionnaires">
                                @foreach ($viewModel->allQuestionnaires as $questionnaire)
                                    <option value="{{ $questionnaire->id }}" name="questionnaireId">
                                        {{ $questionnaire->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-block btn-primary search-btn"><i
                                        class="fa fa-plus"></i> Search</button>
                        </div>
                    </div>
                </div>
                <div id="results"></div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
{{--  todo: find nmp alternatives for these  <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>--}}
    <script src="{{mix('dist/js/reports.js')}}"></script>

@endpush