@extends('landingpages.layout')

@section('content')
    <section>
        @include('landingpages.partials.' . config('app.project_resources_dir') . '.motto')
    </section>
    <section>
        @include('landingpages.partials.' . config('app.project_resources_dir') . '.about')
    </section>
    <section>
        @include('landingpages.partials.' . config('app.project_resources_dir') . '.questionnaire')
    </section>

    @if($viewModel->questionnaire)
        <section id="collective-goal">
            @include('landingpages.partials.' . config('app.project_resources_dir') . '.goal-and-activity')
        </section>
    @endif
@endsection
