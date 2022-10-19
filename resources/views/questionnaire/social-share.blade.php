@push('css')
    <link rel="stylesheet" href="{{ mix('dist/css/social-share.css') }}">
@endpush

<div class="container-fluid">
    <div class="row social-share">
        <div class="col-md-12">
            <h4 class="title" style="margin-bottom: 20px">{{ __("my-dashboard.share_questionnaire")}}</h4>
        </div>
        <div class="col-lg-6 mb-3">
            @include('questionnaire.social-share-media',
            ['viewModel' => $viewModel, 'projects' => $projects, 'mediumName' => "Facebook", 'fontAwesomeBtnClass' => 'fa-facebook-f'])
        </div>
        <div class="col-lg-6">
            @include('questionnaire.social-share-media',
            ['viewModel' => $viewModel, 'projects' => $projects, 'mediumName' => "Twitter", 'fontAwesomeBtnClass' => 'fa-twitter'])
        </div>
        <div class="col-md-12 share-success d-none">
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                {!! __("my-dashboard.thank_you_for_sharing") !!}

            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script defer src="{{ mix('dist/js/questionnaire-social-share.js')}}"></script>
@endpush
