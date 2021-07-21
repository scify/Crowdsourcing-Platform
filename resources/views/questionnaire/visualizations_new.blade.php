@extends('landingpages.layout')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{mix('dist/css/visualizations.css')}}">
@endpush

@section('content')
    <div class="container wide py-5">
        <div class="row">
            <questionnaire-statistics
                    :questionnaire='@json($viewModel->questionnaire)'>
            </questionnaire-statistics>
        </div>
    </div>
@endsection
