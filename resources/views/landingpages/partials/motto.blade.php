<div class="row" id="motto">
    <div class="col-md-12 image-with-text-wrapper p-0"
         style="background-image: url({{asset($viewModel->project->img_path)}});">
        <div class="gray-filter"></div>
        <div class="text">
            <h1 id="project-moto"
                style="color: {{ $viewModel->project->lp_motto_color }}">{!! $viewModel->project->motto !!}</h1>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-2 col-md-4 col-sm-10 call-to-action mx-auto">
                        @include("landingpages.partials.open-questionnaire-button")
                    </div>
                </div>
                @if($viewModel->project->external_url)
                    <div class="row">
                        <div class="col-lg-2 col-md-4 col-sm-10 call-to-action mx-auto text-center">
                            <a href="{{$viewModel->project->external_url}}" target="_blank" class="btn btn-primary">Project
                                Webpage</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
