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
                    <span class="info-box-text">
                        TOTAL # OF ARTICLES
                    </span>
                    <span class="info-box-number">
                        {{ $userViewModel->articles->count() }}
                    </span>
                </div>
            </div>
        </div>
        @if ($userViewModel->totalArticlesBought>0)
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                <span class="info-box-icon bg-green">
                   <i class="ion ion-ios-cart-outline"></i>
                </span>
                    <div class="info-box-content">
                    <span class="info-box-text">
                       Purchased articles
                    </span>
                        <span class="info-box-number">
                       {{$userViewModel->totalArticlesBought}}
                    </span>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow">
                    <span class="fa fa-shopping-basket"></span>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">
                        ARTICLES AT ONLINE STORE
                    </span>
                    <span class="info-box-number">
                        {{$userViewModel->totalArticlesPublishedAtOnlineStore}}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green">
                    <span class="fa fa-euro"></span>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">
                        TOTAL AMOUNT EARNED
                    </span>
                    <span class="info-box-number">
                       {{$userViewModel->totalAmountEarned}} €
                    </span>
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
        <div class="col-md-6 col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">My Location</h3>
                </div>
                <div class="box-body">
                    <div style="position:relative">
                        <input id="pac-input" class="controls form-control" type="text" placeholder="Search Box">
                        <div id="map"></div>
                    </div>
                    @if($userViewModel->location)
                        <span id="set-location" data-lat="{{ $userViewModel->location->lat }}"
                              data-lon="{{ $userViewModel->location->lon }}"
                              data-loc-name="{{ $userViewModel->location->location_name }}"></span>
                    @endif
                    <form action="{{ route('updateLocation') }}" method="post" id="location-update-form">
                        <input name="_token" value="{{ csrf_token() }}" type="hidden">
                        <input id="profile-location-name" type="hidden" name="location_name" value=""/>
                        <input id="profile-lat" type="hidden" name="lat" value=""/>
                        <input id="profile-lon" type="hidden" name="lon" value=""/>
                        <button type="submit" class="btn btn-primary btn-block btn-flat location-btn">Update location
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{--For journalists:
        User can see her email, Update her location in order to receive collaboration requests, view number of articles she has sold, view total amount she has earned
        <br>
        <br>
        For publishers
        User can see her email, view number of articles she has purchased, view total amount she needs to pay.--}}

@stop

@push('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{env("GOOGLE_MAPS_KEY")}}&libraries=places&callback=initGoogleMap"
            async defer></script>

    <script src="{{ mix('dist/js/myProfile.js')}}?{{env("APP_VERSION")}}"></script>
@endpush
