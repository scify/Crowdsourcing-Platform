@extends('landingpages.layout')

@section('content')
    <section>
        <div class="row" id="motto">
            <div class="col-md-12 image-with-text-wrapper p-0"
                 style="background-image: url({{asset($viewModel->project->img_path)}});">
                <div class="gray-filter"></div>
                <div class="text">
                    <h1 id="project-moto">{!! $viewModel->project->motto !!}</h1>
                    <div class="col-md-2 col-md-offset-5 col-xs-6 col-xs-offset-3 call-to-action mx-auto">
                        <h2>{{ $viewModel->getProjectStatusMessage() }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        @include('landingpages.partials.about')
    </section>
@endsection
