
    @if($projects->count() > 1)
        <div class="dropdown show">
            <a class="fb-share-button btn btn-lg btn-default dropdown-toggle {{ strtolower($mediumName) }}"
               href="#" role="button" id="dropdownMenuLink"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fab {{ $fontAwesomeBtnClass }}"></i>{{ $mediumName }}
            </a>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                @foreach($projects as $project)
                    @include('questionnaire.social-share-button', [
                        'project_name' => $project->defaultTranslation->name,
                        'questionnaire_title' => $viewModel->questionnaire->fieldsTranslation->title ,
                        'questionnaire_id' =>$viewModel->questionnaire->id,
                        'socialShareURL' => $viewModel->getSocialShareURL($project, strtolower($mediumName)),
                        'additionalBtnStyleClasses' => 'text-left btn-link mb-2',
                        'btnText' => 'Share for: ' . $project->defaultTranslation->name
                    ])
                @endforeach
            </div>
        </div>
    @else
        @include('questionnaire.social-share-button', [
            'project_name' => $projects->get(0)->defaultTranslation->name,
            'questionnaire_title' => $viewModel->questionnaire->fieldsTranslation->title,
            'questionnaire_id' =>$viewModel->questionnaire->id,
            'socialShareURL' => $viewModel->getSocialShareURL($projects->get(0), strtolower($mediumName)),
            'additionalBtnStyleClasses' => strtolower($mediumName) . ' btn-lg btn-default',
            'btnText' => '<i class="fab ' . $fontAwesomeBtnClass . '"></i>' . $mediumName
        ])
    @endif

