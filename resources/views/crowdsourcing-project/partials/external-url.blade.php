@if($viewModel->projectHasExternalURL())
    <div class="col-md-5 col-sm-12 mx-auto text-center mt-5">
        <a href="{{$viewModel->project->external_url}}" target="_blank" class="btn call-to-action">
            {{ __("project.visit_project_webpage_link_text") }}
        </a>
    </div>
@endif
