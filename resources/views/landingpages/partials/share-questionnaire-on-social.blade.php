@if($viewModel->shareUrlForFacebook || $viewModel->shareUrlForTwitter)
    @push('css')
        @vite('resources/assets/sass/questionnaire/social-share.scss')
    @endpush
    <div class="social-share text-center">
        @include('questionnaire.social-share-button', [
              'project_name' => $viewModel->project->currentTranslation->motto_title ,
              'questionnaire_title' =>  $viewModel->questionnaire->fieldsTranslation->title ,
                'questionnaire_id' =>$viewModel->questionnaire->id,
               'socialShareURL' => $viewModel->shareUrlForFacebook,
               'additionalBtnStyleClasses' =>' facebook btn-lg btn-default',
               'btnText' => '<i class="fab fa-facebook-f"></i> Facebook'
           ])

        @include('questionnaire.social-share-button', [
               'project_name' =>$viewModel->project->currentTranslation->motto_title ,
               'questionnaire_title' => $viewModel->questionnaire->fieldsTranslation->title,
                'questionnaire_id' =>$viewModel->questionnaire->id,
               'socialShareURL' => $viewModel->shareUrlForTwitter,
               'additionalBtnStyleClasses' =>' twitter btn-lg btn-default',
               'btnText' => '<i class="fab fa-twitter"></i> Twitter'
           ])

    </div>
@endif


