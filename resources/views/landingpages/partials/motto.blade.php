<div class="row" id="motto">
    <div class="col-md-12 image-with-text-wrapper no-padding"
         style="background-image: url({{asset($viewModel->project->img_path)}});">
        <div class="gray-filter"></div>
        <div class="text">
            <h1 id="project-moto" style="color: {{ $viewModel->project->lp_motto_color }}">{!! $viewModel->project->motto !!}</h1>
            <div class="col-md-2 col-md-offset-5 col-xs-6 col-xs-offset-3 call-to-action mx-auto">
                @include("landingpages.partials.open-questionnaire-button")
            </div>
        </div>
    </div>
</div>
