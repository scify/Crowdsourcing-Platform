@extends('landingpages.layout', ['includeBackofficeCommonJs' => true])

@section('content')
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col-lg-10 col-md-12 mx-auto">
                <div class="container-fluid px-0">
                    @can('manage-crowd-sourcing-projects')
                        <div class="row my-5">
                            <div class="col">
                                <button id="print-page" class="btn btn-primary btn-lg hidden-print"><i
                                            class="fas fa-print"></i>
                                    {{ __("statistics.print")}}
                                </button>
                            </div>
                        </div>
                    @endcan
                    <div class="row mt-5 mb-3">
                        <div class="col-12">
                            <h1 class="text-lg-center text-md-center text-sm-left">
                                <b>{{ $viewModel->questionnaire->fieldsTranslation->title }}</b>
                            </h1>
                        </div>
                    </div>
                    <hr>
                    @if($viewModel->questionnaire->show_general_statistics)
                        @if($viewModel->questionnaireResponseStatistics->totalResponses)
                            <div class="row my-5 py-5 align-items-center bg-white">
                                <div class="col-lg-3 col-md-6 col-sm-12 offset-lg-1 offset-md-0 offset-sm-0 mb-4 mb-lg-0 mb-md-0">
                                    <h2>{{ __("statistics.total_responses")}}:</h2>
                                </div>
                                <div class="col-lg-7 col-md-6 col-sm-12">
                                    <canvas id="responsesChart"></canvas>
                                </div>
                            </div>
                        @endif
                        @if (sizeof($viewModel->numberOfResponsesPerLanguage->data) > 1)
                            <div class="row my-5 py-5 align-items-center bg-white">
                                <div class="col-lg-3 col-md-6 col-sm-12 offset-lg-1 offset-md-0 offset-sm-0 mb-4 mb-lg-0 mb-md-0">
                                    <h2>{{ __("statistics.responses_per_language")}}:</h2>
                                </div>
                                <div class="col-lg-7 col-md-6 col-sm-12">
                                    <canvas id="responsesPerLanguageChart"></canvas>
                                </div>
                            </div>
                        @endif
                    @endif
                    <div class="row my-5">
                        <questionnaire-statistics
                                :user-id="{{ $viewModel->current_user_id }}"
                                :user-can-annotate-answers="{{ $viewModel->userCanAnnotateAnswers ? 1 : 0 }}"
                                :questionnaire='@json($viewModel->questionnaire)'
                                :projects='@json($viewModel->questionnaire->projects)'
                                :project-filter="{{$viewModel->projectFilter}}">
                        </questionnaire-statistics>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        const viewModel = @json($viewModel);
    </script>
    <script defer type="text/javascript" src="{{mix('dist/js/questionnaire-statistics.js')}}"></script>
@endpush
