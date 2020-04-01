@extends('landingpages.layout')

@section('content')
    <div class="container-fluid">
        <section>
            <div class="row" id="motto">
                <div class="col-md-12 image-with-text-wrapper p-0"
                     style="background-image: url({{asset($viewModel->project->img_path)}});">
                    <div class="gray-filter"></div>
                    <div class="text">
                        <h1 id="project-moto">{!! $viewModel->project->motto !!}
                        <br><br>
                            {!! $viewModel->getProjectStatusMessage() !!}
                        </h1>
                    </div>
                </div>
            </div>
        </section>
        <section>
            @include('landingpages.partials.about')
        </section>
        <section id="projects" class="w-100">
            @include('home.partials.' . config('app.project_resources_dir') . '.projects', ['projects' => $viewModel->projects])
        </section>
    </div>
@endsection
