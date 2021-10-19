<div class="container">

    <div class="goal-title">
        <h2 class="info" style="color: {{ $viewModel->project->lp_primary_color }}">
            @if ($viewModel->totalResponses==0)
                Zero people have spoken up so far. Be the first!
            @else
                <span class="number"><b>{{$viewModel->totalResponses}}</b></span> people have spoken up so far.
                Let's get to <b>{{$viewModel->questionnaire->goal}}</b>!
            @endif

        </h2>
    </div>

    <div class="row activity-container wrapper-box">
        <div class="col-md-6 col-sm-12 text-center">
            @if ($viewModel->totalResponses ==0)
                <p class="no-activity-found-msg"
                   style="color: {{ $viewModel->project->lp_primary_color }}">
                    No recent activity found
                </p>
            @elseif ($viewModel->totalResponses > 0)
                <div class="activity-title wrapper-title">
                    <p style="color: {{ $viewModel->project->lp_primary_color }}">Latest contributors</p>
                </div>
                <div class="activity-content">
                    @foreach($viewModel->allResponses as $response)
                        @if($response->user_name)
                            <div class="activity-item text-left">
                                <i style="color: {{ $viewModel->project->lp_primary_color }}"
                                   class="fa fa-user-circle user-icon" aria-hidden="true"></i>
                                <b>{{$response->user_name}}</b>
                                @if($response->created_at)
                                    responded at {{\Carbon\Carbon::parse($response->created_at)->format('F d, Y')}}
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif

        </div>

        @if($viewModel->questionnaireGoalVM)
            <div class="col-md-6 col-sm-12 text-center center}">
                @include('landingpages.partials.project-goal', ['questionnaireViewModel' => $viewModel->questionnaireGoalVM, 'project' => $viewModel->project])
            </div>
        @endif
    </div>
</div>
