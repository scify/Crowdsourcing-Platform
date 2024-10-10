@if($viewModel->shareUrlForFacebook || $viewModel->shareUrlForTwitter)
    @push('css')
        @vite('resources/assets/sass/questionnaire/social-share.scss')
    @endpush
    <div class="social-share text-center">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-sm-12 mx-auto">
                    @include('questionnaire.social-share-button', [
                      'project_name' => $viewModel->project->currentTranslation->motto_title ,
                      'questionnaire_title' =>  $viewModel->questionnaire->fieldsTranslation->title ,
                        'questionnaire_id' =>$viewModel->questionnaire->id,
                       'socialShareURL' => $viewModel->shareUrlForFacebook,
                       'additionalBtnStyleClasses' =>' facebook btn-lg btn-default',
                       'btnText' => '<i class="fab fa-facebook-f"></i> Facebook'
                   ])
                </div>
                <div class="col-md-6 col-sm-12 mx-auto">
                    @include('questionnaire.social-share-button', [
                       'project_name' =>$viewModel->project->currentTranslation->motto_title ,
                       'questionnaire_title' => $viewModel->questionnaire->fieldsTranslation->title,
                        'questionnaire_id' =>$viewModel->questionnaire->id,
                       'socialShareURL' => $viewModel->shareUrlForTwitter,
                       'additionalBtnStyleClasses' =>' twitter btn-lg btn-default',
                       'btnText' => '<i class="fab fa-twitter"></i> X.com'
                   ])
                </div>
            </div>
        </div>
    </div>
@endif


