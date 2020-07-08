@extends('landingpages.layout')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('dist/css/visualizations.css')}}">
@endpush

@section('content')
    <div class="container-fluid">
    </div>
@endsection

@push('scripts')
    <script src="{{mix('dist/js/visualizations.js')}}"></script>
@endpush
