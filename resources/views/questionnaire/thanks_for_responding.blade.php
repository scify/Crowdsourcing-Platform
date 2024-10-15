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
            @include('crowdsourcing-project.partials.motto')
        </section>
        <section>
            @include('crowdsourcing-project.partials.about')
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
                            {{-- <p class="dashboard-message mt-4 mb-0  w-100">
                                {{ __("questionnaire.login_to_complete_submission") }}</p> --}}
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