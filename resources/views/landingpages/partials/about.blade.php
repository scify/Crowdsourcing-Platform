<div class="row" id="about" style="background-color: {{ $viewModel->project->lp_about_bg_color }}">
    <span id="project" class="h-0 hidden" data-name="{{ $viewModel->project->name }}" data-id="{{ $viewModel->project->id }}"></span>
    <div class="col-md-8 col-sm-12 p-0 mx-auto">
        <div class="content-container" style="color: {{ $viewModel->project->lp_about_color }}">
            {!! $viewModel->project->about !!}
        </div>
    </div>
</div>
