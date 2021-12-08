@push('css')
    <link rel="stylesheet" href="{{ mix('dist/css/social-share.css') }}">
@endpush

<div class="container-fluid">
    <div class="row social-share">
        <div class="col-md-12">
            <h4 class="title" style="margin-bottom: 20px">Share the Questionnaire:</h4>
        </div>
        <div class="col-lg-6">
            @include('questionnaire.social-share-media',
            ['viewModel' => $viewModel, 'projects' => $nextStepVM->projects, 'mediumName' => "Facebook", 'fontAwesomeBtnClass' => 'fa-facebook-f'])
        </div>
        <div class="col-lg-6">
            @include('questionnaire.social-share-media',
            ['viewModel' => $viewModel, 'projects' => $nextStepVM->projects, 'mediumName' => "Twitter", 'fontAwesomeBtnClass' => 'fa-twitter'])
        </div>
        <div class="col-md-12 share-success d-none">
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                Thank you for sharing the Questionnaire! <br>
                You will soon receive an e-mail with your badge!
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script src="{{ mix('dist/js/questionnaireSocialShare.js')}}"></script>
@endpush
