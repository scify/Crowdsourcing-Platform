@extends('backoffice.layout')

@section('content')
    <div class="container-fluid p-0 mb-5">
        <div class="row p-0">
            <div class="col">
                <a href="{{ route('problems.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus mr-2"></i>Create a new problem</a>
            </div>
        </div>
    </div>

    <problems-management></problems-management>
@endsection
@push('scripts')
    @vite('resources/assets/js/project/manage-project-problems.js')
@endpush
