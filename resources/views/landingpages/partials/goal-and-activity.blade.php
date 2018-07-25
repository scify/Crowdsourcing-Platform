<div class="container">

    <div class="goal-title">
        {{-- todo:  If 0 responses , or if target achieved display different messages --}}
        <h2 class="info"><span class="number">{{$viewModel->totalResponses}}</span> people spoke up so far. Let's get
            to {{$viewModel->questionnaire->goal}}!
        </h2>
    </div>

    <div  class="row activity-container wrapper-box"">
        <div class="col-xs-9">
                <div class="activity-title wrapper-title">
                    <p>Recent Activity</p>
                </div>
                <div class="activity-content">
                    @if($viewModel->totalResponses > 0)
                        @foreach($viewModel->allResponses as $response)
                            <div class="activity-item">
                              <img height="30" class="img-circle" src="https://www.gravatar.com/avatar/{{ md5($response->user->email) }}">  {{$response->user->name}} responded at {{$response->created_at->toDayDateTimeString()}}
                            </div>
                        @endforeach
                    @else
                        <p class="no-activity-found-msg">
                            No recent activity found
                        </p>
                    @endif
                </div>
        </div>
        <div class="col-xs-3 text-center">
            <div class="activity-title wrapper-title">
                <p>Target: {{$viewModel->questionnaire->goal}} responses</p>
            </div>
            <div class="progress-container"">
                <div id="progress-bar-circle"
                     data-target="{{$viewModel->targetAchievedPercentage}}">
            </div>

        </div>
    </div>

</div>