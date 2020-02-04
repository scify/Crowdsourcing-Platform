@extends('home.layout')

@section('content')
    <div class="row">
        <section id="motto" class="w-100">
            @include('home.partials.' . config('app.project_resources_dir') . '.motto')
        </section>
        <section id="about" class="w-100">
            @include('home.partials.' . config('app.project_resources_dir') . '.about-us')
        </section>
        <section id="features" class="w-100">
            @include('home.partials.' . config('app.project_resources_dir') . '.features')
        </section>
        <section id="projects" class="w-100">
            @include('home.partials.' . config('app.project_resources_dir') . '.projects')
        </section>
    </div>
@endsection
