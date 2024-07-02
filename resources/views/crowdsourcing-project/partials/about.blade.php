<div class="container">
    <div id="about" class="row align-items-center mx-0">

        <span id="project"
              class="h-0 hidden"
              data-name="{{ $viewModel->project->currentTranslation->name }}"
              data-id="{{ $viewModel->project->id }}"></span>

        <div class="col-md-10 col-sm-12 p-0 mx-auto">
            <div class="content-container">
                {!! $viewModel->project->currentTranslation->about !!}

                @if($viewModel->project->external_url)
                    <div class="text-center">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-5 col-sm-12 mx-auto mt-5">
                                    <a style="background-color: {{ $viewModel->project->lp_primary_color }}"
                                       href="{{$viewModel->project->external_url}}" target="_blank"
                                       class="btn btn-primary visit-project-website call-to-action">
                                        {{ __("questionnaire.visit_projects_site") }}
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>

                @endif
            </div>

        </div>
    </div>

</div>



