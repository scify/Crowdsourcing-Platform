<div class="container">

    <div class="goal-title">
        <h2 class="info" style="color: {{ $viewModel->project->lp_questionnaire_goal_title_color }}">
            @if ($viewModel->totalResponses==0)
                Zero people have spoken up so far. Be the first!
            @else
                <span class="number">{{$viewModel->totalResponses}}</span> people have spoken up so far.
                Let's get to {{$viewModel->questionnaire->goal}}!
            @endif

        </h2>
    </div>

    <div class="row activity-container wrapper-box">
        @can("manage-platform")
            <div class="col-md-6 col-sm-12 text-center">
                @if ($viewModel->totalResponses ==0)
                    <p class="no-activity-found-msg"
                       style="color: {{ $viewModel->project->lp_questionnaire_goal_color }}">
                        No recent activity found
                    </p>
                @elseif ($viewModel->totalResponses > 0)
                    <div class="activity-title wrapper-title">
                        <p style="color: {{ $viewModel->project->lp_questionnaire_goal_color }}">Latest contributors</p>
                    </div>
                    <div class="activity-content">
                        @foreach($viewModel->allResponses as $response)
                            @if($response->user)
                                <div class="activity-item text-left">
                                    <i class="fa fa-user-circle user-icon" aria-hidden="true"></i>
                                    {{$response->user->nickname}}
                                    @if($response->created_at)
                                        responded at {{$response->created_at->toDayDateTimeString()}}
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif

            </div>
        @endcan
        <?php $class = 'center' ?>
        @can("manage-platform")
            <?php $class = '' ?>
        @endcan
        @if($viewModel->questionnaireGoalVM)
            <div class="col-md-6 col-sm-12 text-center {{ $class }}">
                @include('landingpages.partials.project-goal', ['viewModel' => $viewModel->questionnaireGoalVM, 'projectId' => $viewModel->project->id])
            </div>
        @endif
    </div>
</div>
