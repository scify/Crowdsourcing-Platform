<div class="row">
    <div class="col-md-12">
        <div class="content-container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="questionnaire-section-title">{{ $viewModel->project->questionnaire_section_title }}</h3>
                </div>
                <div class="col-md-6">
                    <div class="questionnaire-wrapper wrapper-box">
                        <div class="questionnaire-title wrapper-title">
                            <p>{{$viewModel->questionnaire ? $viewModel->questionnaire->title : 'Questionnaire'}}</p>
                        </div>
                        <div class="questionnaire-content">
                            @if($viewModel->questionnaire)
                                @if($viewModel->userResponse)
                                    <p class="already-responded-msg">
                                        You have already spoken up! Thank you!
                                    </p>
                                @else
                                    <div class="questionnaire-description">{!! $viewModel->questionnaire->description !!}</div>
                                    @if(\Auth::user())
                                        <a id="respond-questionnaire-btn" href="javascript:void(0)"
                                           class="btn btn-block btn-primary"
                                           data-questionnaire-id="{{$viewModel->questionnaire->id}}"
                                           data-url="{{route('respond-questionnaire')}}"
                                           data-toggle="modal" data-target="#questionnaire-modal">
                                            Speak up
                                        </a>
                                    @else
                                        <a href="/login" class="btn btn-block btn-primary login-btn">Login</a>
                                    @endif
                                @endif
                            @else
                                <p class="no-active-questionnaire-msg">
                                    No active questionnaire found.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    @if($viewModel->questionnaire)
                        <div class="gamification-wrapper wrapper-box">
                            <div class="gamification-title wrapper-title">
                                <p>Collective Goal</p>
                            </div>
                            <div class="gamification-content">
                                <div class="progress-container">
                                    <p>Target Reach:</p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                             aria-valuenow="{{$viewModel->targetAchievedPercentage}}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             style="width: {{$viewModel->targetAchievedPercentage}}%;">
                                            <b>{{$viewModel->targetAchievedPercentage}}%</b>
                                        </div>
                                    </div>
                                </div>
                                <p>
                                    <span class="number">{{$viewModel->totalResponses}}</span>
                                    changemakers spoke up
                                </p>
                                <p>
                                    <span class="number">{{$viewModel->responsesNeededToReachGoal}}</span>
                                    more needed to make our voices heard
                                </p>
                            </div>
                        </div>
                        <div class="activity-container wrapper-box">
                            <div class="activity-title wrapper-title">
                                <p>Recent Activity</p>
                            </div>
                            <div class="activity-content">
                                @if($viewModel->totalResponses > 0)
                                    @foreach($viewModel->allResponses as $response)
                                        <div class="activity-item">
                                            {{$response->user->name}} responded at {{$response->created_at}}
                                        </div>
                                    @endforeach
                                @else
                                    <p class="no-activity-found-msg">
                                        No recent activity found
                                    </p>
                                @endif
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