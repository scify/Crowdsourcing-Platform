<div class="row">
    <div class="col-md-12">
        <div class="content-container">
            <div class="row">
                <div class="col-md-12">
                    <h3 style="font-size: 25px; margin: 0 0 50px; text-align: center;">{{ $viewModel->project->questionnaire_section_title }}</h3>
                </div>
                <div class="col-md-6">
                    <div class="questionnaire-wrapper"
                         style="border: 1px solid #99aec1; background-color: white;">
                        <div class="questionnaire-title"
                             style="background-color: #ced8e1; color: black; font-weight: 600;
                             border-bottom: 1px solid #99aec1; text-align: center; padding: 10px;">
                            <p style="font-size: 16px; margin: 0;">{{$viewModel->questionnaire ? $viewModel->questionnaire->title : 'Questionnaire'}}</p>
                        </div>
                        <div class="questionnaire-content" style="padding: 100px 10px;">
                            @if($viewModel->questionnaire)
                                @if($viewModel->questionnaireResponse)
                                    <p style="font-size: 18px; text-align: center; font-style: italic;">
                                        You have already speaken up! Thank you!
                                    </p>
                                @else
                                    <div style="font-size: 18px; text-align: center;">{!! $viewModel->questionnaire->description !!}</div>
                                    @if(\Auth::user())
                                        <a id="respond-questionnaire-btn" href="javascript:void(0)"
                                           class="btn btn-block btn-primary"
                                           style="width: 200px; margin: 20px auto 0;"
                                           data-questionnaire-id="{{$viewModel->questionnaire->id}}"
                                           data-url="{{route('respond-questionnaire')}}"
                                           data-toggle="modal" data-target="#questionnaire-modal">
                                            Speak up
                                        </a>
                                    @else
                                        <a href="/login" class="btn btn-block btn-primary"
                                           style="width: 250px; margin: 20px auto 0;">Login</a>
                                    @endif
                                @endif
                            @else
                                <p style="font-size: 18px; text-align: center; font-style: italic;">
                                    No active questionnaire found.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    @if($viewModel->questionnaire)
                        <div class="gamification-wrapper"
                             style="border: 1px solid #99aec1; height: 250px; background-color: white;">
                            <div class="gamification-title"
                                 style="background-color: #ced8e1; color: black; font-weight: 600;
                             border-bottom: 1px solid #99aec1; text-align: center; padding: 10px;">
                                <p style="font-size: 16px; margin: 0;">Collective Goal</p>
                            </div>
                            <div class="gamification-content" style="font-size: 18px; padding: 15px;">
                                <div class="progress" style="width: 100%;">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                         aria-valuemin="0" aria-valuemax="100" style="width:70%">
                                        <b>70% of target achieved</b>
                                    </div>
                                </div>
                                <p>
                                    <span style="color: #004F9F; font-weight: bold; width: 100px; text-align: right; display: inline-block;">24</span>
                                    changemakers spoke up
                                </p>
                                <p>
                                    <span style="color: #004F9F; font-weight: bold; width: 100px; text-align: right; display: inline-block;">{{$viewModel->questionnaire->goal}}</span>
                                    more needed to make our voices heard
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
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