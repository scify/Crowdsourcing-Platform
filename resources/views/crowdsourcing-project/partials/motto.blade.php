<div id="project-motto-container" class="row h-100 w-100 align-items-center mx-0 bg-img"
     style="background-image: url({{ asset($viewModel->project->img_path) }}); position: relative;">
    <div class="overlay-filter {{ $viewModel->thankYouMode ? 'overlay-thanks' : '' }}"></div>
    <div class="col-lg-7 col-md-8 col-sm-11 mx-auto motto-content">
        <div class="frosted"></div>
        <div id="project-motto" class="h-100">
            <div class="container">
                <div class="row title-row mb-3 text-center">
                    <div class="col-12 px-5">
                        <h1 id="project-title" class="text">
                            {!! $viewModel->project->currentTranslation->name !!}
                        </h1>
                        <h2 id="motto-title" class="text">
                            {!! $viewModel->project->currentTranslation->motto_title !!}
                        </h2>
                        @if ($viewModel->project->currentTranslation->motto_subtitle)
                            <h4 id="motto-subtitle" class="text text-center pt-5">
                                {!! $viewModel->project->currentTranslation->motto_subtitle !!}
                            </h4>
                        @endif
                    </div>
                </div>
                <div class="row pt-3 pb-5">
                    <div class="col-lg-6 col-md-8 col-sm-11 mx-auto">
                        @include('crowdsourcing-project.partials.questionnaire-problems-buttons')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
