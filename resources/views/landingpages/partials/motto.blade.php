<div class="row" id="motto">
    <div class="col-md-12 image-with-text-wrapper p-0"
         style="background-image: url({{asset($viewModel->project->img_path)}});">
        <div class="gray-filter"></div>
        <div id="project-moto" class="container-fluid">
            <div class="row mb-3">
                <div class="col">
                    <h1 id="motto-title" class="text"
                        style="color: {{ $viewModel->project->lp_motto_color }}">{!! $viewModel->project->motto_title !!}</h1>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col">
                    <h4 id="motto-subtitle" class="text">{!! $viewModel->project->motto_subtitle !!}</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-11 mx-auto">
                    <div class="container-fluid">
                        <div class="row">
                            @if($viewModel->questionnaire)
                                @if(!$viewModel->userResponse)
                                    <div class="col-lg-4 col-md-5 col-sm-12 call-to-action mx-auto">
                                        @include("landingpages.partials.open-questionnaire-button")
                                    </div>
                                    @if($viewModel->project->external_url)
                                        <div class="col-5 call-to-action mx-auto text-center">
                                            @include('landingpages.partials.external-url')
                                        </div>
                                    @endif
                                @else
                                    <div class="col-12">
                                        <h2 class="mt-3 text-center">You have already answered this questionnaire.<br>Thank
                                            you for
                                            your response!</h2>
                                    </div>
                                    @if($viewModel->project->external_url)
                                        <div class="col-12">
                                            @include('landingpages.partials.external-url')
                                        </div>
                                    @endif
                                @endif
                            @else
                                @if($viewModel->project->external_url)
                                    <div class="col-12">
                                        @include('landingpages.partials.external-url')
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
