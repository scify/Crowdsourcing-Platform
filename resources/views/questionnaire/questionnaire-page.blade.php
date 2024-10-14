@php use Illuminate\Support\Facades\Auth; @endphp

@extends('crowdsourcing-project.layout')

@push('css')
    <style>
        :root {
            --project-primary-color: {{ $viewModel->project->lp_primary_color}};
        }
    </style>
@endpush

@section('content')

    <div id="questionnaire-lp">

        @include('partials.flash-messages-and-errors')

        <section id="questionnaire-title-and-description" class="bg-clr-primary-white">
            <div class="container px-sm-0">
                <div class="row">
                    <div class="col-12 mt-4 mt-lg-5 pt-4">
                        <h3 id="questionnaireTitle">{{$viewModel->questionnaire->fieldsTranslation->title}}</h3>
                    </div>
                </div>
                @if($viewModel->shouldShowQuestionnaireDescription())
                    <div class="row">
                        <div class="col-12">
                            <div class="description-container">
                                <div class="description">
                                    <p>{!! $viewModel->questionnaire->fieldsTranslation->description !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                @endif
                @if ($viewModel->shouldShowQuestionnaireStatisticsLink())
                    <div class="row mt-4 questionnaire-statistics-link">
                        <div class="col-12  mb-4 mb-lg-5">
                            <p>{{ __("questionnaire.check_what_other_respondents")}}
                                <a class="link"
                                href="{{route('questionnaire.statistics', ['questionnaire' => $viewModel->questionnaire->id])}}"
                                target="_blank">{{ __("questionnaire.here")}}.</a>
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <section id="sign-in-or-anonymous" class="bg-clr-secondary-light-grey">
            <div class="container px-sm-0">
                <div class="row">
                    <div class="col-12 my-4 my-lg-5 pt-4">
                        <questionnaire-display
                                survey-container-id="questionnaire_project"
                                :user='@json($viewModel->getLoggedInUser())'
                                :user-response-data='@json($viewModel->userResponse)'
                                :questionnaire='@json($viewModel->questionnaire)'
                                :project='@json($viewModel->project)'
                                :languages='@json($viewModel->languages)'
                                :moderator='@json($viewModel->moderator)'
                                :locale='@json($viewModel->getLocale())'>
                        </questionnaire-display>
                    </div>
                </div>
            </div>
        </section>

    </div>

    @if (App::environment('local'))
        <div class="fixed-bottom"> <!-- bookmark - for use only during development -->
            <div class="alert alert-danger text-center font-weight-bold" style="top: -40px; width: 160px; margin: 0 auto; opacity: 0.25">
                <div class="d-block d-sm-none">xs (default)</div>
                <div class="d-none d-sm-block d-md-none">sm</div>
                <div class="d-none d-md-block d-lg-none">md</div>
                <div class="d-none d-lg-block d-xl-none">lg</div>
                <div class="d-none d-xl-block d-custom_xxl-none">xl</div>
                <div class="d-none d-custom_xxl-block">custom_xxl</div>
            </div>
        </div>
    @endif

@endsection

@push('scripts')
    @vite('resources/assets/js/questionnaire/questionnaire-page.js')
@endpush
