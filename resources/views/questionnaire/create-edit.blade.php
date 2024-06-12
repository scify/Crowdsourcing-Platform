@extends('loggedin-environment.layout')

@section('content-header')
    <h1>{{$viewModel->title}}</h1>
@endsection

@push('css')
    @vite('resources/assets/sass/questionnaire/create-questionnaire.scss')
@endpush

@section('content')
    <questionnaire-create-edit
            :questionnaire-data='@json($viewModel->questionnaire)'
            :projects='@json($viewModel->projects)'
            :languages='@json($viewModel->languages)'
            :questionnaire-statistics-page-visibility-lkp='@json($viewModel->questionnaireStatisticsPageVisibilityLkp)'
            :translation-meta-data='@json($viewModel->translationMetaData)'
            :questionnaire-fields-translations='@json($viewModel->questionnaireFieldsTranslations)'>
    </questionnaire-create-edit>
@endsection

@push('scripts')
    @vite('resources/assets/js/questionnaire/questionnaire-create-edit.js')
@endpush