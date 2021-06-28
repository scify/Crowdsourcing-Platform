@extends('loggedin-environment.layout')

@section('content-header')
    <h1>{{$viewModel->title}}</h1>
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('dist/css/create-questionnaire.css') }}">
@endpush

@section('content')
    <questionnaire-create-edit
            :questionnaire-data='@json($viewModel->questionnaire)'
            :projects='@json($viewModel->projects)'
            :languages='@json($viewModel->languages)'
            :maximum-prerequisite-order='@json($viewModel->maximumPrerequisiteOrder)'
            :questionnaire-statistics-page-visibility-lkp='@json($viewModel->questionnaireStatisticsPageVisibilityLkp)'>
    </questionnaire-create-edit>
@stop
