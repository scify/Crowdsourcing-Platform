@if($viewModel->project->external_url)
    <div class="col-md-5 col-sm-12 mx-auto mt-5">
        <a href="{{$viewModel->project->external_url}}" target="_blank" class="btn btn-outline-dark call-to-action">
            {{ __("questionnaire.visit_projects_site") }}
        </a>
    </div>
@endif
