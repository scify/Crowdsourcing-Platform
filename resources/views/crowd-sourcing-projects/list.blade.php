@extends('layouts.main-layout')

@section('title', 'home')

@section('content-header')
    <h1>All CrowdSourcing Projects</h1>
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('dist/css/projects-list.css') }}">
@endpush

@section('content')
    @if ($viewModel->projects->isEmpty())
        You haven't published any articles yet!
    @else
        <div class="row projects">
            @foreach($viewModel->projects as $project)
                <div class="col-xs-3">
                    <div class="article">
                        <div class="row header">
                            <div class="col-xs-2 text-center">
                                <i class="fa fa-user"></i>
                            </div>
                            <div class="col-xs-7">
                                <div class="author">By: {{$project->creator_name }}</div>
                                <div class="date">At: {{$project->updated_at}}</div>
                            </div>
                            <div class="col-xs-3 text-right">

                                <a target="_blank" href="{{$project->publicUrl}}"><i class="fa fa-link"></i></a>
                            </div>
                        </div>
                        <div class="image" style="background-image: url({{$project->logo_path}})">
                        </div>
                        <div class="body">
                            <h2>{{$project->name}}</h2>
                            <p>{{$project->motto}}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@stop