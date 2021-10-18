@if($viewModel->project->external_url)
    <div class="col-5 mx-auto call-to-action">
        <a href="{{$viewModel->project->external_url}}" target="_blank" class="btn btn-primary w-100"
           style="color: {{ $viewModel->project->lp_external_url_btn_color }};
                   background-color: {{ $viewModel->project->lp_external_url_btn_bg_color }};">
            Visit project's site
        </a>
    </div>
@endif
