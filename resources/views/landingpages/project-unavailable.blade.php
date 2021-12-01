@extends('landingpages.layout')

@section('content')
    <div class="container-fluid">
        <section>
            <div class="row" id="motto">
                <div class="col-md-12 motto-content p-0"
                     style="background-image: url({{asset($viewModel->project->img_path)}});">
                    <div class="overlay-filter"></div>
                    <div class="text">
                        <h1 id="project-motto">{!! $viewModel->project->defaultTranslation->motto_title !!}
                            <br><br>
                            {!! $viewModel->getProjectStatusMessage() !!}
                        </h1>
                        <div class="row">
                            @if($viewModel->project->external_url)
                                <div class="col-lg-2 col-md-4 col-sm-10 mx-auto">
                                    <a href="{{ $viewModel->project->external_url }}" target="_blank" class="btn btn-primary call-to-action">
                                        Visit Project webpage
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


        </section>
        <section>
            @include('landingpages.partials.about')
        </section>
        <section id="projects" class="w-100">
            @include('home.partials.' . config('app.installation_resources_dir') . '.projects', ['projects' => $viewModel->projects])
        </section>
    </div>
@endsection
