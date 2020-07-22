@extends('loggedin-environment.layout')

@section('content-header')
    <h5>Edit Colors for Questionnaire:</h5><h1 class="text-blue">{{$viewModel->questionnaire->title}}</h1>
@stop

@push('css')
@endpush

@section('content')
    <div class="row my-5 py-5 align-items-center bg-white">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <h2>Total Responses Colors:</h2>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12 offset-lg-1 offset-md-0 offset-sm-0 mb-4 mb-lg-0 mb-md-0">
                    <h3>Goal Responses</h3>
                </div>
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <div class="input-group colorpicker-component color-picker">
                        <input id="goal_responses_color" type="text" name="goal_responses_color" class="form-control"
                               value="{{ old('goal_responses_color') ? old('goal_responses_color') :
                                                            $viewModel->getGoalResponsesDefaultColor()  }}"/>
                        <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12 offset-lg-1 offset-md-0 offset-sm-0 mb-4 mb-lg-0 mb-md-0">
                    <h3>Actual Responses</h3>
                </div>
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <div class="input-group colorpicker-component color-picker">
                        <input id="actual_responses_color" type="text" name="actual_responses_color" class="form-control"
                               value="{{ old('actual_responses_color') ? old('actual_responses_color') :
                                                            $viewModel->getActualResponsesDefaultColor()  }}"/>
                        <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
            </div>
        </div>


    </div>
@stop

@push('scripts')

@endpush
