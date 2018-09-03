<div class="modal fade" id="questionnaire-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{$viewModel->questionnaire->title}}</h4>
            </div>
            <div class="modal-body">
                @if($viewModel->allLanguagesForQuestionnaire->count() > 1)
                    <div id="lang-selector" class="row">
                        <div class="col-md-4 col-md-offset-2">
                            <label for="questionnaire-lang-selector">Select questionnaire's language:</label>
                        </div>
                        <div class="col-md-4">
                            <select name="questionnaire-lang-selector" id="questionnaire-lang-selector"
                                    class="form-control">
                                @foreach($viewModel->allLanguagesForQuestionnaire->all() as $language)
                                    <option data-machine-generated="{{ $language->machine_generated_translation }}"
                                            {{ $language->default ? 'selected' : '' }}
                                            value="{{ $language->language_code }}">
                                        {{$language->language_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div id="machine-translation-indicator" class="col-md-12 text-center ">
                            <i class="fa fa-warning"> Automatically translated by Google translate</i>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div id="questionnaire-display-section"
                             data-content="{{$viewModel->questionnaire->questionnaire_json}}"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>