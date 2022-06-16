@extends('landingpages.layout')
@push('css')
    <style>
        :root  {
            --project-primary-color: {{ $viewModel->project->lp_primary_color}}
}
    </style>
    <link rel="stylesheet" href="{{ mix('dist/css/questionnaire-thanks.css') }}">
@endpush

@section('content')
    <div class="container-fluid h-100 w-100 px-0" id="questionnaire-thanks">
        @include('partials.flash-messages-and-errors')
        <section id="motto">
            @include('landingpages.partials.motto')
        </section>
        <section>
            @include('landingpages.partials.about')
        </section>
    </div>
@endsection