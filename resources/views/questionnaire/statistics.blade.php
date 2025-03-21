@extends('crowdsourcing-project.layout', [
    'includeBackofficeCommonJs' => true,
    'redirectLoginURL' => route("login") . '?redirectTo=' . url()->full(),
    'redirectRegisterURL' => route("register") . '?redirectTo=' . url()->full(),
    ])

@push('css')
    <style>
        :root {
            --project-primary-color: {{ $viewModel->getProjectPrimaryColor()}};
            --btn-text-color: {{ $viewModel->getProjectBtnTextColor()}};
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col-lg-10 col-md-12 mx-auto">
                <div class="container-fluid px-0">
                    @can('manage-platform-content')
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
                                <div class="col-xl-6 col-lg-9 col-md-12 col-sm-12 mx-auto">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-sm-12 offset-lg-1 offset-md-0 offset-sm-0 mb-4 mb-lg-0 mb-md-0">
                                            <h2>{{ __("statistics.total_responses")}}:</h2>
                                        </div>
                                        <div class="col-lg-7 col-md-6 col-sm-12">
                                            <canvas id="responsesChart"></canvas>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endif
                        @if (sizeof($viewModel->numberOfResponsesPerLanguage->data) > 1)
                            <div class="row my-5 py-5 align-items-center bg-white">
                                <div class="col-xl-6 col-lg-9 col-md-12 col-sm-12 mx-auto">
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-12 offset-lg-1 offset-md-0 offset-sm-0 mb-4 mb-lg-0 mb-md-0">
                                            <h2>{{ __("statistics.responses_per_language")}}:</h2>
                                        </div>
                                        <div class="col-lg-7 col-md-6 col-sm-12">
                                            <canvas id="responsesPerLanguageChart"></canvas>
                                        </div>
                                    </div>
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
                                :project-filter="{{$viewModel->projectFilter}}"
                                :show-file-type-questions-statistics="{{ $viewModel->userCanViewFileTypeQuestionsStatistics() }}">
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
    @vite('resources/assets/js/questionnaire/questionnaire-statistics.js')
@endpush
