@extends('loggedin-environment.layout')

@section('content-header')
    <h1>Dashboard</h1>
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('dist/css/my-profile.css') }}">
@endpush

@section('content')

    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Welcome</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            Under construction: Call to action to answer the question should be displayed here and any
                            welcome material
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">My contribution</h3>
                </div>
                <div class="box-body">
                    <div class="row">

                        <div class="col-md-12">
                            You haven't responsed so far [todo: display a list of pending projects here]
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xs-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Gamification Elements</h3>
                </div>
                <div class="box-body">
                    <div class="row">

                        <div class="col-md-12">
                            A summary of gamification tools can be displayed here. Badges and action required for next
                            level
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script src="{{ mix('dist/js/myProfile.js')}}?{{env("APP_VERSION")}}"></script>
@endpush
