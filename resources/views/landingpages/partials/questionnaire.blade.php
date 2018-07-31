@if ($viewModel->questionnaire)
    <div id="questionnaire-wrapper" class="text-center content-container ">
        <h3 class="questionnaire-section-title">{{ $viewModel->userResponse?"You have already participated, thank you!":   $viewModel->questionnaire->title }}</h3>
        @if(!$viewModel->userResponse)
            <div class="questionnaire-description">{!! $viewModel->questionnaire->description !!}</div>
            @include("landingpages.partials.open-questionnaire-button")
        @endif

    </div>

@else
    <div id="questionnaire-wrapper" class="text-center content-container ">
        <h3 class="questionnaire-section-title">No active questionnaires</h3>
    </div>
@endif



@if($viewModel->questionnaire)
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
                                    @foreach($viewModel->allLanguagesForQuestionnaire as $key => $language)
                                        <option value="{{$language->language_code}}" {{$key === 0 ? 'selected' : ''}}>
                                            {{$language->language_name}}
                                        </option>
                                    @endforeach
                                </select>
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
@endif