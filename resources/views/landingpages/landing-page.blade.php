@extends('landingpages.layout')

@section('content')
    <div class="container-fluid">
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
            <section id="collective-goal"
                     style="background-color: {{ $viewModel->project->lp_questionnaire_goal_bg_color }}">
                @include('landingpages.partials.goal-and-activity')
            </section>
        @endif
        <section>
            @include('partials.signup_to_newsletter')
        </section>
    </div>
@endsection
