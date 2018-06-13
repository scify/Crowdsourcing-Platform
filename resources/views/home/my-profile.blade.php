@extends('layouts.main-layout')

@section('content-header')
    <h1>My profile</h1>
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('dist/css/my-profile.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua">
                    <span class="fa fa-file-text-o"></span>
                </span>
                <div class="info-box-content">

                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Personal Details</h3>
                </div>
                <div class="box-body">
                    <div class="details-table">
                        <div>
                            <span>Full name:</span><span>{{ $userViewModel->fullName }}</span>
                        </div>
                        <div>
                            <span>Email:</span><span>{{ $userViewModel->email }}</span>
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
