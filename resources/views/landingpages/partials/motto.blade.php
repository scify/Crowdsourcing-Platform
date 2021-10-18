<div class="row h-100 w-100 align-items-center mx-0 bg-img"
     style="background-image: url({{asset($viewModel->project->img_path)}});">
    <div class="gray-filter"></div>
    <div class="col-lg-5 col-md-6 col-sm-11 mx-auto motto-content px-0">
        <div class="frosted"></div>
        <div id="project-motto" class="container-fluid">
            <div class="row mb-3 text-center">
                <div class="col">
                    <h1 id="motto-title" class="text"
                        style="color: {{ $viewModel->project->lp_motto_color }}">{!! $viewModel->project->motto_title !!}</h1>
                </div>
            </div>
            @if($viewModel->project->motto_subtitle)
                <div class="row mb-5">
                    <div class="col">
                        <h4 id="motto-subtitle" class="text">{!! $viewModel->project->motto_subtitle !!}</h4>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-10 col-sm-11 mx-auto">
                    <div class="container-fluid">
                        <div class="row">
                            @if($viewModel->questionnaire)
                                @if(!$viewModel->userResponse)
                                    <div class="col-md-5 col-sm-12 call-to-action mx-auto">
                                        @include("landingpages.partials.open-questionnaire-button")
                                    </div>
                                    @if($viewModel->project->external_url)
                                        <div class="col-md-5 col-sm-12 call-to-action mx-auto text-center">
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
                                        <div class="col-5 mx-auto call-to-action">
                                            @include('landingpages.partials.external-url')
                                        </div>
                                    @endif
                                @endif
                            @else
                                @if($viewModel->project->external_url)
                                    <div class="col-5 mx-auto call-to-action">
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
