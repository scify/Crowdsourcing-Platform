@extends('landingpages.layout')
@push('css')
    <style>
        :root  {
            --project-primary-color: {{ $viewModel->project->lp_primary_color}}
}
    </style>
@endpush

@section('content')
    <div class="container-fluid h-100 w-100 px-0">
        @include('partials.flash-messages-and-errors')
        <section id="motto" style="height: 650px;">
            @include('landingpages.partials.motto')
        </section>
        <section>
            @include('landingpages.partials.about')
        </section>
    </div>
@endsection