@extends('landingpages.layout')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('dist/css/visualizations.css')}}">
@endpush

@section('content')
    <div class="container wide py-5">
        @can('manage-crowd-sourcing-projects')
            <div class="row my-5">
                <div class="col">
                    <button id="print-page" class="btn btn-primary btn-lg hidden-print"><i class="fas fa-print"></i>
                        Print
                    </button>
                </div>
            </div>
        @endcan
        <div class="row my-5">
            <div class="col-12">
                <h1 class="text-lg-center text-md-center text-sm-left"><b>{{ $viewModel->questionnaire->title }}</b>
                </h1>
            </div>
        </div>
        <div class="row my-5">
            <div class="col-12">
                <h1 class="text-lg-center text-md-center text-sm-left">Total Questionnaire Statistics:</h1>
            </div>
        </div>
        <div class="row my-5 py-5 align-items-center bg-white">
            <div class="col-lg-3 col-md-6 col-sm-12 offset-lg-1 offset-md-0 offset-sm-0 mb-4 mb-lg-0 mb-md-0">
                <h2>Total Responses:</h2>
            </div>
            <div class="col-lg-7 col-md-6 col-sm-12">
                <canvas id="responsesChart"></canvas>
            </div>
        </div>
        <div class="row my-5 py-5 align-items-center bg-white">
            <div class="col-lg-3 col-md-6 col-sm-12 offset-lg-1 offset-md-0 offset-sm-0 mb-4 mb-lg-0 mb-md-0">
                <h2>Responses per language:</h2>
            </div>
            <div class="col-lg-7 col-md-6 col-sm-12">
                <canvas id="responsesPerLanguageChart"></canvas>
            </div>
        </div>
        <div class="row my-5">
            <div class="col-12">
                <h1 class="text-lg-center text-md-center text-sm-left">Statistics per question:</h1>
            </div>
        </div>
        @foreach($viewModel->statisticsPerQuestion as $questionStatistics)
            <div class="row my-4 py-4 align-items-center bg-white">
                <div class="col-lg-3 col-md-6 col-sm-12 offset-lg-1 offset-md-0 offset-sm-0 mb-4 mb-lg-0 mb-md-0">
                    <h2>{{ $questionStatistics['question_title'] }}</h2>
                </div>

                @if($questionStatistics['question_type'] === 'fixed_choices')
                    <div class="col-lg-7 col-md-6 col-sm-12">
                        <canvas class="questionResponsesChart"
                                data-question-id="{{ $questionStatistics['question_id'] }}"></canvas>
                    </div>
                @else
                    <div class="col-lg-10 col-md-12 col-sm-12 offset-lg-1 offset-md-0 offset-sm-0 mt-3">
                        <table cellspacing="0"
                               class="questionResponsesTable w-100 table table-striped table-bordered"
                               data-question-id="{{ $questionStatistics['question_id'] }}">
                            <thead>
                            <tr>
                                <th>Translated Answer</th>
                                <th>Original Answer</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($questionStatistics['statistics'] as $index => $answer)
                                <tr>
                                    <td>{{ $answer['answer_text'] }}
                                        @if($answer['is_translated'])
                                            <span class="ml-2" title="Translated by Google Translate"><i
                                                        class="fab fa-google"></i></span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($answer['is_translated'])
                                            <div>
                                                {{ $answer['answer_original_text'] }}
                                            </div>
                                            <div class="mt-3">
                                                Language: <span
                                                        class="font-weight-bold">{{ $answer['origin_language']['language_name'] }}</span>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        @endforeach
    </div>
@endsection
@push('modals')
    <div class="modal fade" id="answerTranslationModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Question: "<span id="questionTitle"></span>"</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body py-4">
                    <p class="mb-3">Original answer: <span id="originalAnswer"></span></p>
                    <p class="mb-0">Language: <span id="originalAnswerLanguage"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
                </div>
            </div>
        </div>
    </div>
@endpush
@push('scripts')
    <script type="text/javascript">
        const viewModel = @json($viewModel);
    </script>
    <script type="text/javascript" src="{{mix('dist/js/visualizations.js')}}"></script>
@endpush
