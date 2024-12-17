@extends('home.layout')

@section('content')
    <section id="motto" class="w-100 mb-5" style="height: 650px;">
        @include('home.partials.motto')
    </section>
    <section id="about" class="container-fluid w-100 py-5">
        @include('home.partials.' . config('app.installation_resources_dir') . '.about-us')
    </section>
    <section id="projects" class="w-100 py-5">
        @include('home.partials.projects')
    </section>
    <section id="features" class="container-fluid w-100 py-5">
        @include('home.partials.features')
    </section>

@endsection
