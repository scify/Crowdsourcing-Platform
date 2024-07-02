@php use Illuminate\Support\Facades\Auth; @endphp
@extends('crowdsourcing-project.layout')

@section('content')
    <div class="container" id="questionnaire-content">
        <div class="row">
            <div class="col">
                <h3 id="questionnaireTitle">{{$viewModel->questionnaire->fieldsTranslation->title}}</h3>
            </div>
        </div>
        @if($viewModel->shouldShowQuestionnaireDescription())
            <div class="row">
                <div class="col-12">
                    <div class="description-container">
                        <div class="description">
                            <h5>{!! $viewModel->questionnaire->fieldsTranslation->description !!}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        @endif
        @if ($viewModel->shouldShowQuestionnaireStatisticsLink())
            <div class="row mt-4">
                <div class="col-md-12 text-left">
                    <h5>{{ __("questionnaire.check_what_other_respondents")}}
                        <a class="link"
                           href="{{route('questionnaire.statistics', ['questionnaire' => $viewModel->questionnaire->id])}}"
                           target="_blank">{{ __("questionnaire.here")}}.</a></h5>
                </div>
            </div>
            <hr>
        @endif
        <div class="row">
            <div class="col">
                <section>
                    <questionnaire-display
                            survey-container-id="questionnaire_project"
                            :user='@json($viewModel->getLoggedInUser())'
                            :user-response-data='@json($viewModel->userResponse)'
                            :questionnaire='@json($viewModel->questionnaire)'
                            :project='@json($viewModel->project)'
                            :languages='@json($viewModel->languages)'
                            :moderator='@json($viewModel->moderator)'
                            :locale='@json($viewModel->getLocale())'>
                    </questionnaire-display>
                </section>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @vite('resources/assets/js/questionnaire/questionnaire-page.js')
@endpush