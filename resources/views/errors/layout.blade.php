@extends('home.layout')
@push('css')
    <link rel="stylesheet" href="{{ asset('dist/css/errors.css') }}">
@endpush
@section('title_prefix')
    @yield('title')
@endsection
@section('content')
    <section>
        <div class="flex-center position-ref error-container row">
            <div class="content col-md-9 col-sm-11">
                <div class="code">
                    @yield('code')
                </div>
                <div class="title">
                    @yield('message')
                </div>
            </div>
        </div>
    </section>
    <section id="projects" class="w-100">
        @include('home.partials.' . config('app.project_resources_dir') . '.projects')
    </section>
@endsection

