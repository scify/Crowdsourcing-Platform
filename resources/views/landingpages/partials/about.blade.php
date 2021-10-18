<div class="container">
    <div id="about" class="row align-items-center mx-0"
         style="background-color: {{ $viewModel->project->lp_about_bg_color }}">

        <span id="project"
              class="h-0 hidden"
              data-name="{{ $viewModel->project->name }}"
              data-id="{{ $viewModel->project->id }}"></span>

        <div class="col-md-10 col-sm-12 p-0 mx-auto">
            <div class="content-container" style="color: {{ $viewModel->project->lp_about_color }}">
                {!! $viewModel->project->about !!}

                @if($viewModel->project->external_url)
                    <div class="text-center">


                    <a href="{{$viewModel->project->external_url}}" target="_blank" class="btn btn-primary visit-project-website "
                       style="color: {{ $viewModel->project->lp_external_url_btn_color }};
                               background-color: {{ $viewModel->project->lp_external_url_btn_bg_color }};">
                        Visit project's site
                    </a>
                    </div>

                @endif
            </div>

        </div>
    </div>

</div>



