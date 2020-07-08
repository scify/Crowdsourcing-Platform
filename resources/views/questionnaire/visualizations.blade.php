@extends('landingpages.layout')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('dist/css/visualizations.css')}}">
@endpush

@section('content')
    <div class="container wide">
        <div class="row my-5">
            <div class="col-12">
                <h1 class="text-lg-center text-md-center text-sm-left"><b>{{ $viewModel->questionnaire->title }}</b></h1>
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
        <div class="row my-5 py-5 align-items-center bg-white">
            <div class="col-lg-3 col-md-6 col-sm-12 offset-lg-1 offset-md-0 offset-sm-0 mb-4 mb-lg-0 mb-md-0">
                <h2>Responses per language:</h2>
            </div>
            <div class="col-lg-7 col-md-6 col-sm-12">
                <canvas id="responsesPerLanguageChart"></canvas>
            </div>
        </div>
        <div class="row my-5">
            <div class="col-12">
                <h1 class="text-lg-center text-md-center text-sm-left">Statistics per question:</h1>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        const viewModel = @json($viewModel);
    </script>
    <script type="text/javascript" src="{{mix('dist/js/visualizations.js')}}"></script>
@endpush
