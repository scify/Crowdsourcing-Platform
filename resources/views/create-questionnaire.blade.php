@extends('loggedin-environment.layout')

@section('content-header')
    <h1>Create Questionnaire</h1>
@stop

@push('css')
    <link href="https://surveyjs.azureedge.net/1.0.30/survey.css" type="text/css" rel="stylesheet"/>
    <link href="https://surveyjs.azureedge.net/1.0.30/surveyeditor.css" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('dist/css/create-questionnaire.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div id="editorElement"></div>
        </div>
    </div>
@stop

@push('scripts')
    {{--<script src="https://surveyjs.azureedge.net/1.0.30/survey.jquery.min.js"></script>--}}
    {{--<script src="https://surveyjs.azureedge.net/1.0.30/surveyeditor.js"></script>--}}
    <script src="{{asset('dist/js/createQuestionnaire.js')}}"></script>
@endpush