@if ($viewModel->questionnaire)
        <div id="questionnaire-wrapper" class="text-center content-container ">
            <h3 class="questionnaire-section-title">{{ $viewModel->userResponse?"You have already participated, thank you!":   $viewModel->questionnaire->title }}</h3>
            @if(!$viewModel->userResponse)
                <div class="questionnaire-description">{!! $viewModel->questionnaire->description !!}</div>
                @if(\Auth::user())
                    <a id="respond-questionnaire-btn" href="javascript:void(0)"
                       class="btn btn-primary"
                       data-questionnaire-id="{{$viewModel->questionnaire->id}}"
                       data-url="{{route('respond-questionnaire')}}"
                       data-toggle="modal" data-target="#questionnaire-modal">
                        Speak up
                    </a>
                @else
                    <a href="/login" class="btn btn-primary ">Login</a>
                @endif
            @endif

        </div>

@else
    <p class="no-active-questionnaire-msg">
        No active questionnaire found.
    </p>
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