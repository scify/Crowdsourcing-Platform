@extends('home.layout')
@push('css')
    <link rel="stylesheet" href="{{ asset('dist/css/errors.css') }}">
@endpush
@section('title_prefix')
    @yield('title')
@endsection
@section('content')
    <section>
        <div class="flex-center position-ref error-container">
            <div class="content">
                <div class="code">
                    @yield('code')
                </div>
                <div class="title">
                    @yield('message')
                </div>
            </div>
        </div>
    </section>
@endsection

