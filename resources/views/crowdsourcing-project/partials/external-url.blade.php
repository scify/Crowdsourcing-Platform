@if($viewModel->projectHasExternalURL())
    <div class="col-md-5 col-sm-12 mx-auto text-center mt-5">
        <a href="{{$viewModel->project->external_url}}" target="_blank" class="btn call-to-action">
            {{ __("questionnaire.visit_projects_site") }}
        </a>
    </div>
@endif
