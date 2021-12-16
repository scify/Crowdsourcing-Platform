@extends('landingpages.layout')

@section('content')
    <div class="container-fluid h-100 w-100 px-0">
        @include('partials.flash-messages-and-errors')
        <section id="motto" style="height: 650px;">
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
        <section>
            @include('partials.signup_to_newsletter')
        </section>
    </div>
@endsection
@push('scripts')
    <script src="{{mix('dist/js/landingPage.js')}}"></script>
@endpush
