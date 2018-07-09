@extends('loggedin-environment.layout')

@section('content-header')
    <h1>Create Questionnaire</h1>
@stop

@push('css')
    <link href="{{asset('dist/css/survey.css')}}" type="text/css" rel="stylesheet"/>
    <link href="{{asset('dist/css/surveyeditor.css')}}" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('dist/css/create-questionnaire.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    Questionnaire Info
                </div>
                <div class="box-body">
                    <div class="row form-group">

                        <div class="col-md-2 col-sm-3 col-xs-12">
                            <label for="title">Questionnaire's Title</label>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="title" id="title"
                                   placeholder="Insert questionnaire's title">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2 col-sm-3 col-xs-12">
                            <label for="language">Default Language</label>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            {{--English by default--}}
                            <select name="language_id" id="language" style="width: 100%;">
                                @foreach($languages as $language)
                                    <option value="{{$language->id}}" @if($language->language_name === 'English') selected @endif>
                                        {{$language->language_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <em>Use the editor below to create a new questionnaire.</em>
                        </div>
                    </div>
                    <div id="questionnaire-editor"></div>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-offset-10 col-md-2">
                            <a href="javascript:void(0)" id="save" class="btn btn-block btn-primary">Save</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script src="{{asset('dist/js/createQuestionnaire.js')}}"></script>
@endpush