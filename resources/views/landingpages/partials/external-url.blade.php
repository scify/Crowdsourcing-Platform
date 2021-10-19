@if($viewModel->project->external_url)
    <div class="col-5 mx-auto call-to-action">
        <a href="{{$viewModel->project->external_url}}" target="_blank" class="btn btn-outline-dark w-100">
            Visit project's site
        </a>
    </div>
@endif
