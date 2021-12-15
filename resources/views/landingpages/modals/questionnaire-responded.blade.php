<div class="modal fade" id="questionnaire-responded" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    @if(\Illuminate\Support\Facades\Auth::check())
                        {{ __("questionnaire.thank_you") }}
                    @else
                        {{ __("questionnaire.almost_there") }}
                    @endif
                </h4>
            </div>

            <div class="modal-body">
                @if(!\Illuminate\Support\Facades\Auth::check())
                    <h2 class="anonymous-title text-left">{{ __("questionnaire.answers_saved_anonymously") }}</h2>
                    <p class="dashboard-message mt-4 mb-0 text-left w-100">
                        {{ __("questionnaire.login_to_complete_submission") }}</p>
                    <p class="dashboard-message mt-4 text-left w-100">{!! __("questionnaire.by_registering_you") !!}</p>
                    <ul>
                        <li>- {!! __("questionnaire.filter_spammers") !!}</li>
                        <li>- {!! __("questionnaire.view_your_contribution") !!}</li>
                        <li>- {!! __("questionnaire.vote_thumbs_up") !!}</li>
                    </ul>
                    <label>
                        * <i>{!! __("questionnaire.no_share_information") !!}</i><br>
                        * <i>{!! __("questionnaire.during_registration") !!}</i>
                    </label>

                    <a href="{{ route('register') }}"
                       class="btn btn-lg btn-block btn-primary">{{ __("questionnaire.sign_up") }}
                        / {{ __("questionnaire.sign_in") }}</a>

                    {{-- if feedback questionnaire is assigned to the project --}}
                    @if ($viewModel->feedbackQuestionnaire)
                        <p class="dashboard-message mt-4 text-left w-100">{!! __("questionnaire.prefer_staying_anonymous") !!}</p>
                        <label>{!! __("questionnaire.feedback_about_platform") !!}</label>
                        @include("landingpages.partials.open-feedback-questionnaire-button",
                                 [
                                     "css_class"=> "",
                                     "label"=>  __("questionnaire.give_us_feedback")
                                 ])
                    @endif
                @else
                    <div class="row">
                        <div class="col-md-12 badge-container"></div>
                    </div>
                @endif

            </div>
            <div class="modal-footer">
                @if(\Illuminate\Support\Facades\Auth::check())
                    <p class="dashboard-message w-100">{{ __("questionnaire.visit_dashboard_and_invite") }}</p>
                    <a href="{{ route('my-dashboard') }}"
                       class="btn btn-lg btn-block btn-primary">{{ __("questionnaire.go_to_dashboard") }}</a>
                @endif
            </div>
        </div>
    </div>
</div>
