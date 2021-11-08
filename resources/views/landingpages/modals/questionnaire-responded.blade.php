<div class="modal fade" id="questionnaire-responded" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    @if(\Illuminate\Support\Facades\Auth::check())
                        Thank you!
                    @else
                        Almost there!
                    @endif
                </h4>
            </div>

            <div class="modal-body">
                @if(!\Illuminate\Support\Facades\Auth::check())

                    <p class="dashboard-message mt-4 mb-4 text-left w-100">Your answers have been saved anonymously. <br>
                        Please login to complete your submission!</p>
                    <a href="{{ route('register') }}" class="btn btn-lg btn-block btn-primary">Sign up / sign in</a>
                    <p class="dashboard-message mt-4 text-left w-100">By signing-in<sup>*</sup> you
                        <ul>
                            <li>- Help us <strong>filter out</strong> spammers, people who answer randomly.</li>
                            <li>- Can <strong>view</strong> your contribution, <strong>compare your answers</strong> with others.</li>
                            <li>- <strong>Vote/Thumbs up</strong> the best answers</li>
                        </ul>
                    <label>
                        * <i> We don't share your information to 3rd parties.</i><br>
                        * <i>During registration you are asked for an email and a nickname.</i>
                    </label>
                    </p>
                @else
                    <div class="row">
                        <div class="col-md-12 badge-container"></div>
                    </div>
                @endif

            </div>
            <div class="modal-footer">
                @if(\Illuminate\Support\Facades\Auth::check())
                    <p class="dashboard-message w-100">Visit your Dashboard to invite your friends</p>
                    <a href="{{ route('my-dashboard') }}" class="btn btn-lg btn-block btn-primary">Go to Dashboard</a>
                @endif
            </div>
        </div>
    </div>
</div>
