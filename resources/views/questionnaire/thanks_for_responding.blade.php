@php use Illuminate\Support\Facades\Auth; @endphp
@extends('crowdsourcing-project.layout')
@push('css')
    <style>
        :root {
            --project-primary-color: {{ $viewModel->project->lp_primary_color}};
            --btn-text-color: {{ $viewModel->project->lp_btn_text_color_theme == "light" ? "#ffffff" : "#212529"}};
        }
    </style>
    @vite('resources/assets/sass/questionnaire/questionnaire-thanks.scss')
@endpush

@section('content')
    <div class="container-fluid h-100 w-100 px-0" id="questionnaire-thanks">
        @include('partials.flash-messages-and-errors')
        <section id="motto">
            <div id="project-motto-container" class="row h-100 w-100 align-items-center mx-0 bg-img"
                 style="background-image: url({{ asset($viewModel->project->img_path) }}); position: relative;">
                <div class="overlay-filter overlay-thanks"></div>
                <div class="col-lg-7 col-md-8 col-sm-11 mx-auto motto-content">
                    <div class="frosted"></div>
                    <div id="project-motto" class="h-100">
                        <div class="container">
                            <div class="row title-row mb-3 text-center">
                                <div class="col-12 px-5">
                                    <h1 id="project-title" class="text">
                                        {!! $viewModel->project->currentTranslation->name !!}
                                    </h1>
                                    @if($viewModel->project->currentTranslation->name !== $viewModel->project->currentTranslation->motto_title)
                                        <h2 id="motto-title" class="text">
                                            {!! $viewModel->project->currentTranslation->motto_title !!}
                                        </h2>
                                    @endif
                                </div>
                            </div>
                            <div class="row pt-3 pb-5">
                                <div class="col-lg-7 col-md-9 col-sm-11 mx-auto">
                                    <h4 class="project-section-title text-center"
                                        style="line-height: 2.5rem; font-weight: bold;">
                                        {!! $viewModel->project->currentTranslation->thank_you_message ?? __("questionnaire.thank_you_next_steps") !!}
                                    </h4>
                                </div>
                            </div>
                            <div class="row pt-3 pb-5">
                                <div class="col-lg-6 col-md-8 col-sm-11 mx-auto text-center">
                                    <h3>Response ID: {{ $viewModel->response_id }}</h3>
                                </div>
                            </div>
                            @if($viewModel->moderator)
                                <div class="row pt-3 pb-5">
                                    <div class="col-lg-6 col-md-8 col-sm-11 mx-auto text-center">
                                        <a href="{{ route('questionnaires.all', ['locale' => app()->getLocale()]) }}"
                                           class="btn btn-primary w-75 respond-questionnaire call-to-action">
                                            {{ __("menu.see_all_questionnaires") }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@if (!Auth::check())
    @push("modals")
        <div class="modal fade anonymous-response" id="questionnaire-responded" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title">
                            {{ __('questionnaire.thank_you') }}
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <h2 class="anonymous-answers-saved text-center">{{ __('questionnaire.answers_saved_anonymously') }}
                        </h2>
                        <div class="login-invitation">
                            <p class="dashboard-message mt-4 w-100">{!! __('questionnaire.by_registering_you') !!}</p>
                            <ul>
                                <li>- {!! __('questionnaire.filter_spammers') !!}</li>
                                <li>- {!! __('questionnaire.view_your_contribution') !!}</li>
                                <li>- {!! __('questionnaire.vote_thumbs_up') !!}</li>
                            </ul>
                            <label>
                                * <i>{!! __('questionnaire.no_share_information') !!}</i><br>
                                * <i>{!! __('questionnaire.during_registration') !!}</i>
                            </label>


                        </div>
                        {{-- if feedback questionnaire is assigned to the project --}}
                        @if ($viewModel->feedbackQuestionnaire)
                            <div class="text-center mb-3">
                                <p class="prefer-staying-anonymous dashboard-message mt-4 text-center w-100">
                                    {!! __('questionnaire.prefer_staying_anonymous') !!}</p>
                                <a href="javascript:window.location.href=window.location.href"
                                   class="go-to-homepage">{!! __('questionnaire.go_to_homepage') !!}</a>
                            </div>
                            <div class="text-center p-4 bck-color-feedback">
                                <label>{!! __('questionnaire.feedback_about_platform') !!}</label><br>
                                @include("crowdsourcing-project.partials.open-feedback-questionnaire-button",
                                [
                                "css_class"=> "",
                                "label"=> __("questionnaire.give_us_feedback")
                                ])
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <p class="dashboard-message w-100">{{ __('questionnaire.learn_about_new_projects') }}</p>
                        <a href="{{ route('register') }}"
                           class="btn btn-primary">{{ __('questionnaire.sign_up') }}
                            / {{ __('questionnaire.sign_in') }}</a>
                    </div>
                </div>
            </div>
        </div>
    @endpush
@endif
@push('scripts')
    @vite('resources/assets/js/questionnaire/questionnaire-thanks.js')
@endpush