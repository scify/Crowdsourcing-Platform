<div class="container">
    <div id="about" class="row align-items-center mx-0">

        <span id="project"
              class="h-0 hidden"
              data-name="{{ $viewModel->project->name }}"
              data-id="{{ $viewModel->project->id }}"></span>

        <div class="col-md-10 col-sm-12 p-0 mx-auto">
            <div class="content-container">
                {!! $viewModel->project->about !!}

                @if($viewModel->project->external_url)
                    <div class="text-center call-to-action">
                        <a style="background-color: {{ $viewModel->project->lp_primary_color }}"
                           href="{{$viewModel->project->external_url}}" target="_blank"
                           class="btn btn-primary visit-project-website ">
                            Visit project's site
                        </a>
                    </div>

                @endif
            </div>

        </div>
    </div>

</div>



