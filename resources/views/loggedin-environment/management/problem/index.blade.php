@extends('loggedin-environment.layout')

@section('content')
    <problems-management></problems-management>
@endsection
@push('scripts')
    @vite('resources/assets/js/project/manage-project-problems.js')
@endpush
