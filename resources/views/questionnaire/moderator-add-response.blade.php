@php use Illuminate\Support\Facades\Auth; @endphp
@extends('landingpages.layout')
@push('css')
    <style>
        :root {
            --project-primary-color: {{ $viewModel->project->lp_primary_color}}

        }
    </style>
    @vite('resources/assets/sass/questionnaire/questionnaire-display.scss')
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
        <section>
            @include('landingpages.partials.questionnaire')
        </section>
    </div>
@endsection
@push('scripts')
    <script defer type="text/javascript">
		const viewModel = @json($viewModel);
    </script>
    @vite('resources/assets/js/project/landing-page.js')
@endpush