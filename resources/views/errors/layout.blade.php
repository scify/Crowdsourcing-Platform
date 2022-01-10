@extends('home.layout')
@push('css')
    <link rel="stylesheet" href="{{ mix('dist/css/errors.css') }}">
@endpush
@section('title_prefix')
    @yield('title')
@endsection
@section('content')
    <section>
        <div class="flex-center position-ref error-container row">
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
    <section id="home" class="w-100">
        <div class="row">
            <div class="col">
                <a class="btn btn-primary btn-block">{{ __('badges_messages.contribute') }}</a>
            </div>
        </div>
    </section>
@endsection

