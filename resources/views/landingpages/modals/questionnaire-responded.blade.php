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
                    <p class="dashboard-message mt-4 mb-4  w-100">Please login to complete your submission:</p>
                    <a href="{{ route('register') }}" class="btn btn-lg btn-block btn-primary">Sign up / sign in</a>
                    <p class="dashboard-message mt-4 mb-4 w-100">After you complete your submission, you will receive the following badge:</p>

                @endif
                <div class="row">
                    <div class="col-md-12 badge-container"></div>
                </div>
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
