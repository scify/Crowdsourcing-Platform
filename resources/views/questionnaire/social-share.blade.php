@push('css')
    <link rel="stylesheet" href="{{ asset('dist/css/social-share.css') }}">
@endpush

<div class="row social-share"
     data-href="{{ url('/' . $viewModel->project->slug) }}?open=1&referrerId={{ $viewModel->referrerId }}"
     data-questionnaireid="{{ $viewModel->questionnaire->id }}"
     data-postshareurl="{{ url('/questionnaire/share') }}">
    <div class="col-md-12">
        <div class="col-md-12">
            <h4 class="title" style="margin-bottom: 20px">Share the Questionnaire:</h4>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-4 align-right">
            <button type="button"
                    class="social-share-button fb-share-button facebook btn btn-lg btn-default">
                <i class="fa fa-facebook" aria-hidden="true"></i>Facebook
            </button>
        </div>
        <div class="col-md-4 align-left">
            <button type="button" class="social-share-button twitter-share-button twitter btn btn-lg btn-default">
                <i class="fa fa-twitter" aria-hidden="true"></i>Twitter</button>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>

@push('scripts')
    <script src="{{ mix('dist/js/questionnaireSocialShare.js')}}?{{env("APP_VERSION")}}"></script>
@endpush