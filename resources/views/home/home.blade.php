@extends('home.layout')

@section('content')
    <section id="motto" class="w-100" style="height: 650px;">
        @include('home.partials.' . config('app.installation_resources_dir') . '.motto')
    </section>
    <section id="about" class="container-fluid w-100">
        @include('home.partials.' . config('app.installation_resources_dir') . '.about-us')
    </section>
    <section id="projects" class="w-100">
        @include('home.partials.' . config('app.installation_resources_dir') . '.projects')
    </section>
    <section id="features" class="container-fluid w-100">
        @include('home.partials.' . config('app.installation_resources_dir') . '.features')
    </section>

@endsection
