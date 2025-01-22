@extends('backoffice.layout')
@section('content-header')
    <h1>All Crowdsourcing Projects</h1>
@endsection

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Upload Image</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.image.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group py-5">
                    <label for="image">Choose an image to upload:</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary btn-slim">Upload</button>
            </form>
        </div>
    </div>
@endsection