@extends('loggedin-environment.layout')

@push('css')
@endpush

@section('content')
    <form action="{{ route('statistics-colors', $viewModel->questionnaire) }}"
          method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="card card-primary">
            <div class="card-header">
                <h4>Edit Colors for Questionnaire:</h4>
                <h3 class="font-weight-bold">{{$viewModel->questionnaire->currentFieldsTranslation->title}}</h3>
            </div>
            <div class="card-body">
                <div class="container mt-4">
                    <div class="row">
                        <div class="col p-0">
                            <h3 class="font-weight-bold">Total Responses Colors:</h3>
                        </div>
                    </div>
                    <div class="row my-3 py-5 align-items-center bg-gradient-light">
                        <div class="container-fluid">
                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-6 col-sm-12 offset-lg-1 offset-md-0 offset-sm-0 mb-4 mb-lg-0 mb-md-0">
                                    <h4>Goal Responses</h4>
                                </div>
                                <div class="col-lg-7 col-md-6 col-sm-12">
                                    <div class="input-group colorpicker-component color-picker">
                                        <input id="goal_responses_color" type="text" name="goal_responses_color"
                                               class="form-control"
                                               value="{{ old('goal_responses_color') ? old('goal_responses_color') :
                                                            $viewModel->getGoalResponsesDefaultColor()  }}"/>
                                        <span class="input-group-addon"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-sm-12 offset-lg-1 offset-md-0 offset-sm-0 mb-4 mb-lg-0 mb-md-0">
                                    <h4>Actual Responses</h4>
                                </div>
                                <div class="col-lg-7 col-md-6 col-sm-12">
                                    <div class="input-group colorpicker-component color-picker">
                                        <input id="actual_responses_color" type="text" name="actual_responses_color"
                                               class="form-control"
                                               value="{{ old('actual_responses_color') ? old('actual_responses_color') :
                                                            $viewModel->getActualResponsesDefaultColor()  }}"/>
                                        <span class="input-group-addon"><i></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col p-0">
                            <h3 class="font-weight-bold">Language Statistics Colors:</h3>
                        </div>
                    </div>
                    <div class="row my-3 py-5 align-items-center bg-gradient-light">
                        <div class="container-fluid">
                            @foreach($viewModel->questionnaire->questionnaireLanguages as $questionnaireLanguage)
                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-6 col-sm-12 offset-lg-1 offset-md-0 offset-sm-0 mb-4 mb-lg-0 mb-md-0">
                                        <h4>{{ $questionnaireLanguage->language->language_name }}
                                            ({{ $questionnaireLanguage->language->language_code }})</h4>
                                    </div>
                                    <div class="col-lg-7 col-md-6 col-sm-12">
                                        <div class="input-group colorpicker-component color-picker">
                                            <input id="lang_colors_{{ $questionnaireLanguage->language->language_code }}"
                                                   type="text"
                                                   name="lang_colors[{{ $questionnaireLanguage->id }}]"
                                                   class="form-control"
                                                   value="{{ old('lang_colors[' . $questionnaireLanguage->id . ']') ? old('lang_colors[' . $questionnaireLanguage->id . ']') :
                                                            $viewModel->getColorForQuestionnaireLanguage($questionnaireLanguage)  }}"/>
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-offset-10 col-md-2">
                            <button type="submit"
                                    class="btn btn-block btn-primary btn-lg">Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
@endsection
