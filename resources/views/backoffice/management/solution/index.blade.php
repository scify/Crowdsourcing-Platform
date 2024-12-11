@extends('backoffice.layout')

@section('content')
    <solutions-management></solutions-management>
@endsection
@push('scripts')
    @vite('resources/assets/js/solution/manage-solutions.js')
@endpush
