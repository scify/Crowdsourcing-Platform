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
                    <h1 id="motto-title" class="text">{!! $viewModel->project->currentTranslation->motto_title !!}</h1>
                </div>
            </div>
            @if($viewModel->project->currentTranslation->motto_subtitle)
                <div class="row mb-5">
                    <div class="col">
                        <h4 id="motto-subtitle" class="text text-center">{!! $viewModel->project->currentTranslation->motto_subtitle !!}</h4>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-10 col-sm-11 mx-auto">
                    <div class="container-fluid">
                        <div class="row">
                            @if($viewModel->questionnaire)
                                @if(!$viewModel->userResponse)
                                    <div class="col-md-5 col-sm-12 mx-auto">
                                        @include("landingpages.partials.open-questionnaire-button", ["label"=>"Answer the questionnaire"])
                                    </div>
                                @else
                                    <div class="col-12">
                                        <h2 class="mt-3 text-center">You have already answered this questionnaire.<br>Thank
                                            you for
                                            your response!</h2>
                                    </div>
                                    @include('landingpages.partials.external-url')
                                @endif
                            @else
                                @include('landingpages.partials.external-url')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
