@if($viewModel->shareUrlForFacebook || $viewModel->shareUrlForTwitter)
    @push('css')
        @vite('resources/assets/sass/questionnaire/social-share.scss')
    @endpush
    @if($viewModel->shareUrlForFacebook)
        @include('questionnaire.social-share-button', [
            'project_name' => $viewModel->project->currentTranslation->motto_title ,
            'questionnaire_title' =>  $viewModel->questionnaire->fieldsTranslation->title ,
            'questionnaire_id' =>$viewModel->questionnaire->id,
            'socialShareURL' => $viewModel->shareUrlForFacebook,
            'additionalBtnStyleClasses' =>' facebook m-2 d-flex justify-content-between align-items-center',
            'btnText' => '<i class="fab fa-facebook-f"></i>Facebook<i class="fab fa-facebook-f invisible"></i>'
        ])
    @endif
    @if($viewModel->shareUrlForTwitter)
        @include('questionnaire.social-share-button', [
            'project_name' =>$viewModel->project->currentTranslation->motto_title ,
            'questionnaire_title' => $viewModel->questionnaire->fieldsTranslation->title,
            'questionnaire_id' =>$viewModel->questionnaire->id,
            'socialShareURL' => $viewModel->shareUrlForTwitter,
            'additionalBtnStyleClasses' =>' twitter m-2 d-flex justify-content-between align-items-center',
            'btnText' => '<i class="fab fa-twitter"></i>X.com<i class="fab fa-twitter invisible"></i>'
        ])
    @endif
@endif


