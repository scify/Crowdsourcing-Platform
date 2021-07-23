@extends('landingpages.layout')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{mix('dist/css/statistics.css')}}">
@endpush

@section('content')
    <div class="container wide py-5">
        @can('manage-crowd-sourcing-projects')
            <div class="row my-5">
                <div class="col">
                    <button id="print-page" class="btn btn-primary btn-lg hidden-print"><i class="fas fa-print"></i>
                        Print
                    </button>
                </div>
            </div>
        @endcan
        <div class="row my-5">
            <div class="col-12">
                <h1 class="text-lg-center text-md-center text-sm-left"><b>{{ $viewModel->questionnaire->title }}</b>
                </h1>
            </div>
        </div>
        <div class="row my-5">
            <div class="col-12">
                <h1 class="text-lg-center text-md-center text-sm-left">Total Questionnaire Statistics:</h1>
            </div>
        </div>
        <div class="row my-5 py-5 align-items-center bg-white">
            <div class="col-lg-3 col-md-6 col-sm-12 offset-lg-1 offset-md-0 offset-sm-0 mb-4 mb-lg-0 mb-md-0">
                <h2>Total Responses:</h2>
            </div>
            <div class="col-lg-7 col-md-6 col-sm-12">
                <canvas id="responsesChart"></canvas>
            </div>
        </div>
        @if (sizeof($viewModel->numberOfResponsesPerLanguage->data))
            <div class="row my-5 py-5 align-items-center bg-white">
                <div class="col-lg-3 col-md-6 col-sm-12 offset-lg-1 offset-md-0 offset-sm-0 mb-4 mb-lg-0 mb-md-0">
                    <h2>Responses per language:</h2>
                </div>
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <canvas id="responsesPerLanguageChart"></canvas>
                </div>
            </div>
        @endif
        <div class="row my-5">
            <div class="col-12">
                <h1 class="text-lg-center text-md-center text-sm-left">Statistics per question:</h1>
            </div>
        </div>
        <div class="row">
            <questionnaire-statistics
                    :questionnaire='@json($viewModel->questionnaire)'>
            </questionnaire-statistics>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        const viewModel = @json($viewModel);
    </script>
    <script type="text/javascript" src="{{mix('dist/js/statistics.js')}}"></script>
@endpush
