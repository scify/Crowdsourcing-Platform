@extends('landingpages.layout')

@section('content')
    <section>
        @include('landingpages.partials.motto')
    </section>
    <section>
        @include('landingpages.partials.about')
    </section>
    <section>
        @include('landingpages.partials.questionnaire')
    </section>

    @if($viewModel->questionnaire)
        <section id="collective-goal">
            @include('landingpages.partials.goal-and-activity')
        </section>
    @endif
@endsection
