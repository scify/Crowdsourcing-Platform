@extends('landingpages.layout')
@push('css')
    <style>
        :root {
            --project-primary-color: {{ $viewModel->project->lp_primary_color}}




        }
    </style>
@endpush
@section('content')
    <div class="container-fluid h-100 w-100 px-0">
        <section id="motto" style="height: 650px;">
            <div id="project-motto-container" class="row h-100 w-100 align-items-center mx-0 bg-img"
                 style="background-image: url({{asset($viewModel->project->img_path)}});">
                <div class="overlay-filter"
                     style="background-color: {{ $viewModel->project->lp_primary_color }};
                 top: @if (App::environment('staging')) 128.75px @else 93.75px @endif"></div>
                <div class="col-lg-7 col-md-8 col-sm-11 mx-auto motto-content px-0">
                    <div class="frosted"></div>
                    <div id="project-motto" class="container-fluid">
                        <div class="row mb-3 text-center">
                            <div class="col">
                                <h1 id="motto-title"
                                    class="text">{!! $viewModel->project->currentTranslation->motto_title !!}</h1>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col">
                                <h3 class="text text-center">{!! $viewModel->getProjectStatusMessage() !!}</h3>
                            </div>
                        </div>
                        <div class="row">
                            @if($viewModel->project->external_url)
                                <div class="col-lg-3 col-md-4 col-sm-10 mx-auto">
                                    <a href="{{ $viewModel->project->external_url }}" target="_blank"
                                       class="btn btn-primary call-to-action">
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
