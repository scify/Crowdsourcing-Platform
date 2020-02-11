@extends('loggedin-environment.layout')

@section('content-header')
    <h1>Translate</h1>
@stop

@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('dist/css/translate-questionnaire.css')}}">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">{{$viewModel->questionnaire->title}}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p>Default language: <b>{{$viewModel->defaultLanguage->language_name}}</b></p>
                        </div>
                        <div class="col-md-12">
                            <a href="javascript:void(0)" class="btn btn-block btn-primary" id="new-lang-btn"
                               data-toggle="modal" data-target="#add-new-lang-modal">
                                <i class="fa fa-plus"></i> Add new language
                            </a>
                        </div>
                    </div>
                    <div class="row {{$viewModel->questionnaireTranslations->count() <= 1 ? 'hide' : ''}}">
                        <div class="col-md-12">
                            <div class="languages-wrapper"
                                 data-questionnaire-id="{{ $viewModel->questionnaire->id }}"
                                 data-mark-translation-url="{{ route('mark-translation') }}"
                                 data-delete-translation-url="{{ route('delete-translation') }}"></div>
                        </div>
                        <div class="col-md-12">
                            <div class="translation-wrapper"
                                 data-translations="{{$viewModel->questionnaireTranslations}}"
                                 data-languages="{{$viewModel->questionnaireLanguages}}"
                                 data-url="{{route('automatic-translation')}}"></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-2 col-md-offset-10">
                            <button class="btn btn-block btn-primary save-translations"
                               data-url="{{route('translate-questionnaire', ['id' => $viewModel->questionnaire->id])}}">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    <div id="add-new-lang-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New translation language</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="language-to-translate">Available languages:</label>
                        <select class="form-control" name="language" id="language-to-translate">
                            @foreach($viewModel->allLanguages as $language)
                                <option {{ $viewModel->getDisabledAttribute($language) }} value="{{$language->id}}" data-lang-code="{{$language->language_code}}">{{$language->language_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0)" class="btn btn-block btn-primary">
                        Add new language
                    </a>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script src="{{mix('/dist/js/translateQuestionnaire.js')}}"></script>
@endpush
