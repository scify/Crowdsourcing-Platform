@extends('backoffice.layout')

@section('content')
    <div class="container-fluid p-0 mb-5">
        <div class="row p-0">
            <div class="col">
                <a href="{{ route('problems.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus mr-2"></i>{{ __('menu.create_new_problem') }}</a>
            </div>
        </div>
    </div>

    <problems-management></problems-management>
@endsection
@push('scripts')
    @vite('resources/assets/js/problem/manage-problems.js')
@endpush
