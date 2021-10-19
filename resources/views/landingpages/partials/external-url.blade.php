@if($viewModel->project->external_url)
    <div class="col-5 mx-auto">
        <a href="{{$viewModel->project->external_url}}" target="_blank" class="btn btn-outline-dark call-to-action">
            Visit project's site
        </a>
    </div>
@endif
