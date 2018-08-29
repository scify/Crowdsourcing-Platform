@push('css')
    <link rel="stylesheet" href="{{ asset('dist/css/social-share.css') }}">
@endpush

<div class="row social-share">
    <div class="col-md-12">
        <div class="col-md-12">
            <h4 class="title" style="margin-bottom: 20px">Share the Questionnaire:</h4>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-4 align-right">
            <a target="_blank"
               href="https://www.facebook.com/sharer/sharer.php?u={{ $viewModel->getSocialShareURL() }}"
                    class="social-share-button fb-share-button facebook btn btn-lg btn-default">
                <i class="fa fa-facebook" aria-hidden="true"></i>Facebook
            </a>
        </div>
        <div class="col-md-4 align-left">
            <a target="_blank" href="https://twitter.com/share?url={{ $viewModel->getSocialShareURL() }}"
               class="social-share-button twitter-share-button twitter btn btn-lg btn-default">
                <i class="fa fa-twitter" aria-hidden="true"></i>Twitter
            </a>
        </div>
        <div class="col-md-2"></div>
    </div>

    <div class="col-md-12 share-success hidden">
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            Thank you for sharing the Questionnaire! <br>
            You will soon receive an e-mail with your badge!
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ mix('dist/js/questionnaireSocialShare.js')}}?{{env("APP_VERSION")}}"></script>
@endpush