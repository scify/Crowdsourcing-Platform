<div class="modal fade" id="questionnaire-responded" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            @if (\Illuminate\Support\Facades\Auth::check())
                <div class="modal-header">
                    <h4 class="modal-title">
                        {{ __('questionnaire.thank_you') }}
                    </h4>
                </div>
            @endif


            <div class="modal-body">
                @if (!\Illuminate\Support\Facades\Auth::check())
                    <h2 class="anonymous-answers-saved text-center">{{ __('questionnaire.answers_saved_anonymously') }}
                    </h2>

                    <div class="login-invitation">
                        {{-- <p class="dashboard-message mt-4 mb-0  w-100">
                            {{ __("questionnaire.login_to_complete_submission") }}</p> --}}
                        <p class="dashboard-message mt-4 mb-0 w-100">{!! __('questionnaire.by_registering_you') !!}</p>
                        <ul>
                            <li>- {!! __('questionnaire.filter_spammers') !!}</li>
                            <li>- {!! __('questionnaire.view_your_contribution') !!}</li>
                            <li>- {!! __('questionnaire.vote_thumbs_up') !!}</li>
                        </ul>
                        <label>
                            * <i>{!! __('questionnaire.no_share_information') !!}</i><br>
                            * <i>{!! __('questionnaire.during_registration') !!}</i>
                        </label>

                        <a href="{{ route('register') }}"
                            class="btn btn-lg btn-primary">{{ __('questionnaire.sign_up') }}
                            / {{ __('questionnaire.sign_in') }}</a>
                    </div>
                    {{-- if feedback questionnaire is assigned to the project --}}
                    @if ($viewModel->feedbackQuestionnaire)
                        <div class="text-center mb-3">
                            <p class="prefer-staying-anonymous dashboard-message mt-4 text-center w-100">
                                {!! __('questionnaire.prefer_staying_anonymous') !!}</p>
                            <a href="javascript:window.location.href=window.location.href" class="go-to-homepage">{!! __('questionnaire.go_to_homepage') !!}</a>
                        </div>
                        <div class="text-center p-4 bck-color-feedback">
                            <label>{!! __('questionnaire.feedback_about_platform') !!}</label><br>
                            @include("landingpages.partials.open-feedback-questionnaire-button",
                            [
                            "css_class"=> "",
                            "label"=> __("questionnaire.give_us_feedback")
                            ])
                        </div>
                    @endif
                @else
                    <div class="row">
                        <div class="col-md-12 badge-container"></div>
                    </div>
                @endif

            </div>
            <div class="modal-footer">
                @if (\Illuminate\Support\Facades\Auth::check())
                    <p class="dashboard-message w-100">{{ __('questionnaire.visit_dashboard_and_invite') }}</p>
                    <a href="{{ route('my-dashboard') }}"
                        class="btn btn-lg btn-block btn-primary">{{ __('questionnaire.go_to_dashboard') }}</a>
                @endif
            </div>
        </div>
    </div>
</div>
