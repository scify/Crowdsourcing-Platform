<div id="project-motto-container" class="row h-100 w-100 align-items-center mx-0 bg-img"
     style="background-image: url({{asset($viewModel->project->img_path)}});">
    <div class="overlay-filter"
         style="background-color: {{ $viewModel->project->lp_primary_color }};
                 top: @if (App::environment('staging')) 128.75px @else 93.75px @endif"></div>
    <div class="col-lg-7 col-md-8 col-sm-11 mx-auto motto-content px-0">
        <div class="frosted"></div>
        <div id="project-motto" class="container-fluid">
            <div class="row mb-3 text-center">
                <div class="col">
                    <h1 id="motto-title" class="text">{{ $viewModel->project->currentTranslation->name }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
