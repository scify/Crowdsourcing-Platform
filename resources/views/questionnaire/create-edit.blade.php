@extends('loggedin-environment.layout')

@section('content-header')
    <h1>{{$viewModel->title}}</h1>
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
                    @if($viewModel->questionnaire)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="warning-wrapper">
                                    <i class="glyphicon glyphicon-alert"></i>
                                    Please notice, that if you click on the button "Save" below, your questionnaire's
                                    translations will not be synchronized with the latest questionnaire's changes. You
                                    need to revisit the translations to make sure that it will be correctly displayed
                                    in different languages.
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row form-group">
                        <div class="col-md-2 col-sm-3 col-xs-12">
                            <label for="title">Questionnaire's Title</label>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" name="title" id="title"
                                   placeholder="Insert questionnaire's title"
                                   value="{{$viewModel->questionnaire ? $viewModel->questionnaire->title : ''}}">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2 col-sm-3 col-xs-12">
                            <label for="description">Description - Motto</label>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <textarea class="form-control" name="description" id="description"
                                      required
                                      placeholder="Insert questionnaire's description">{{$viewModel->questionnaire ? $viewModel->questionnaire->description : ''}}</textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2 col-sm-3 col-xs-12">
                            <label for="goal">Responses Goal</label>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <input type="number" class="form-control" name="goal" id="goal"
                                   required
                                   placeholder="Insert questionnaire's goal"
                                   value="{{$viewModel->questionnaire ? $viewModel->questionnaire->goal : ''}}">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2 col-sm-3 col-xs-12">
                            <label for="language">Default Language</label>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            {{--English by default--}}
                            <select name="language_id" id="language" style="width: 100%;">
                                @foreach($viewModel->languages as $language)
                                    <option value="{{$language->id}}"
                                            {{ $viewModel->shouldLanguageBeSelected($language) ? 'selected' : '' }}>
                                        {{$language->language_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 editor-wrapper">
                            <em>Use the editor below to {{ $viewModel->questionnaire ? 'modify' : 'create' }} your
                                questionnaire.</em>
                            <div id="questionnaire-editor"
                                 data-json="{{$viewModel->questionnaire ? $viewModel->questionnaire->questionnaire_json : ''}}"></div>
                        </div>
                    </div>
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

    {{--todo: move to webpack--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.0/knockout-min.js"></script>
    <script src="https://surveyjs.azureedge.net/1.0.41/survey.ko.min.js"></script>
    <script src="https://surveyjs.azureedge.net/1.0.41/surveyeditor.min.js"></script>

    <script src="{{asset('dist/js/createQuestionnaire.js')}}"></script>
@endpush
