@extends('home.layout')

@section('content')
    <section id="motto">
        @include('home.partials.' . config('app.project_resources_dir') . '.motto')
    </section>
    <section id="about">
        @include('home.partials.' . config('app.project_resources_dir') . '.about-us')
    </section>
    <section id="features">
        @include('home.partials.' . config('app.project_resources_dir') . '.features')
    </section>
    <section id="projects">
        @include('home.partials.' . config('app.project_resources_dir') . '.projects')
    </section>
@endsection
