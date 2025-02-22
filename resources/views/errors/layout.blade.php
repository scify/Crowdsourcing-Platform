@extends('home.layout', ['onErrorPage' => true])
@push('css')
    @vite('resources/assets/sass/shared/errors.scss')
@endpush
@section('title_prefix')
    @yield('title')
@endsection
@section('content')
    <section class="container-fluid">
        <div class="flex-center position-ref error-container row w-100">
            <div class="content col-md-9 col-sm-11" style="margin-top: 6rem">
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
        @include('home.partials.projects')
    </section>
@endsection

