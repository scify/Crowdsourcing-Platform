<div class="row" id="about" style="background-color: {{ $viewModel->project->lp_about_bg_color }}">
    <div class="col-md-12 no-padding">
        <div class="content-container" style="color: {{ $viewModel->project->lp_about_color }}">
            {!! $viewModel->project->about !!}
        </div>
    </div>
</div>
