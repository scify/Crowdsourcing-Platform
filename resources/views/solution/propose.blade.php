@extends('crowdsourcing-project.layout')
@push('header-scripts')
    <script async src="https://www.google.com/recaptcha/api.js?render={{config('services.recaptcha.key')}}"></script>
@endpush
@push('css')
    <script>
        function onSubmit(token) {
            console.log("onSubmit")
            const translationNotice = document.getElementById('translation-notice');
            const consentNotice = document.getElementById('consent-notice');
            const errorMessageDiv = document.getElementById('error-messages');
            let valid = true;
            let errorMessages = [];

            if (!translationNotice.checked) {
                errorMessages.push("{{ __('solution.translation_notice_required') }}");
                valid = false;
            }

            if (!consentNotice.checked) {
                errorMessages.push("{{ __('solution.consent_notice_required') }}");
                valid = false;
            }

            if (valid) {
                document.getElementById("solution-form").submit();
            } else {
                grecaptcha.reset();
                errorMessageDiv.innerHTML = errorMessages.join('<br>');
                errorMessageDiv.style.display = 'block';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('translation-notice').addEventListener('click', function () {
                document.getElementById('error-messages').style.display = 'none';
            });
            document.getElementById('consent-notice').addEventListener('click', function () {
                document.getElementById('error-messages').style.display = 'none';
            });
        });
    </script>
    @vite('resources/assets/sass/solution/propose-page.scss')
    <style>
        :root {
            --project-primary-color:
                {{ $viewModel->project->lp_primary_color}}
            ;
            --btn-text-color:
                {{ $viewModel->project->lp_btn_text_color_theme == "light" ? "#ffffff" : "#212529"}}
            ;
        }

        .login-message {
            color: var(--project-primary-color, #000);
        }

        .call-to-action {
            border-color: var(--project-primary-color, #000);
            color: var(--project-primary-color, #000);
            transition: all 0.3s ease;
        }

        .call-to-action:hover {
            background-color: var(--project-primary-color, #000);
            color: var(--btn-text-color, #fff);
            text-decoration: none;
        }

        .btn-primary.call-to-action {
            background-color: var(--project-primary-color, #000);
            color: var(--btn-text-color, #fff);
        }

        .btn-primary.call-to-action:hover {
            opacity: 0.9;
        }

        .submission-closed-message {
            color: var(--project-primary-color, #000);
            text-align: center;
            padding: 3rem 0;
        }

        .submission-closed-icon {
            font-size: 4rem;
            color: #dc3545;
            margin-bottom: 1.5rem;
        }
    </style>
@endpush

@section('content')

    <div id="propose-solution-page" class="pb-5">

        @include('partials.flash-messages-and-errors')

        <section id="propose-solution-overview" class="bg-clr-primary-white">
            @include('solution.partials.propose-solution-overview')
        </section>

        @if(!$viewModel->project->solution_submission_open)
            <!-- Show submission closed message -->
            <section id="submission-closed" class="bg-clr-primary-white bg-image-noise">
                <div class="container-fluid pt-0 pb-5">
                    <div class="row justify-content-center">
                        <div class="col-sm-11 col-md-10 col-lg-8 col-xl-6">
                            <div class="submission-closed-message">
                                <div class="submission-closed-icon">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <h4 class="my-4">{{ __('solution.submission_closed') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @else
            <!-- Show normal form/login flow when submissions are open -->
            <section id="propose-solution-form" class="bg-clr-primary-white bg-image-noise">
                <!-- Show login prompt if user is not logged in -->
                @if(!Auth::check())
                    <div class="container-fluid pt-0 pb-5">
                        <div class="row justify-content-center">
                            <div class="col-sm-11 col-md-10 col-lg-8 col-xl-6">
                                <div class="container-fluid">
                                    <div class="row mb-5 pt-3">
                                        <div class="col text-center">
                                            <h4 class="login-message">{!! __('solution.login_prompt_message') !!}</h4>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center d-none d-md-flex">
                                        <div class="col-5">
                                            <a class="btn btn-primary btn-lg call-to-action w-100"
                                                href="{{ route('login', ['locale' => app()->getLocale()]) }}?redirectTo={{ url()->current() }}">
                                                {{ __('questionnaire.sign_in') }}
                                            </a>
                                        </div>
                                        <div class="col-5">
                                            <button class="btn btn-primary btn-lg call-to-action w-100"
                                                onclick="showSolutionForm()">
                                                {{ __('solution.submit_anonymously') }}
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center d-flex d-md-none">
                                        <div class="col-10">
                                            <a class="btn btn-primary btn-lg call-to-action w-100 mb-3"
                                                href="{{ route('login', ['locale' => app()->getLocale()]) }}?redirectTo={{ url()->current() }}">
                                                {{ __('questionnaire.sign_in') }}
                                            </a>
                                        </div>
                                        <div class="col-10">
                                            <button class="btn btn-primary btn-lg call-to-action w-100"
                                                onclick="showSolutionForm()">
                                                {{ __('solution.submit_anonymously') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden form that appears when user chooses to submit anonymously -->
                    <div id="anonymous-solution-form" class="d-none">
                        @include('solution.partials.new-solution-form')
                    </div>
                @else
                    <!-- Show form for logged-in users -->
                    @include('solution.partials.new-solution-form')
                @endif
            </section>
        @endif

    </div>

@endsection

@push('scripts')
    <script>
        function showSolutionForm() {
            // Hide the login prompt
            document.querySelector('#propose-solution-form .container-fluid').classList.add('d-none');
            // Show the solution form
            document.getElementById('anonymous-solution-form').classList.remove('d-none');
            // Scroll to the form
            document.getElementById('anonymous-solution-form').scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    </script>
@endpush