@extends('crowdsourcing-project.layout')
@push('css')
    <style>
        :root {
            --project-primary-color: {{ $viewModel->project->lp_primary_color}}

        }
    </style>
@endpush

@section('content')
    <div class="container-fluid h-100 w-100 px-0">
        @include('partials.flash-messages-and-errors')
        <section id="problems-hero" style="height: 650px;">
            @include('crowdsourcing-project.problems.partials.problems-hero')
        </section>
        <section id="problems-list">
            @include('crowdsourcing-project.problems.partials.problems-list')
        </section>
    </div>
@endsection
@push('scripts')
    <script defer type="text/javascript">
		const viewModel = @json($viewModel);
    </script>
    @vite('resources/assets/js/project/landing-page.js')
@endpush
