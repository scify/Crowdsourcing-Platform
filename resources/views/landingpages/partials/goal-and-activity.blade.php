<div class="container">

    <div class="goal-title">
        {{-- todo:  If 0 responses , or if target achieved display different messages --}}
        <h2 class="info">
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
            <div class="col-xs-9">
                @if ($viewModel->totalResponses ==0)
                    <p class="no-activity-found-msg">
                        No recent activity found
                    </p>
                @elseif ($viewModel->totalResponses > 0)
                    <div class="activity-title wrapper-title">
                        <p>Latest contributors</p>
                    </div>
                    <div class="activity-content">
                        @foreach($viewModel->allResponses as $response)
                            @if($response->user)
                                <div class="activity-item">
                                    {{--<img height="30" class="img-circle"--}}
                                    {{--src="https://www.gravatar.com/avatar/{{ md5($response->user->email) }}"> --}}
                                    <i class="fa fa-user-circle user-icon" aria-hidden="true"></i>
                                    {{$response->user->nickname}}
                                    responded at {{$response->created_at->toDayDateTimeString()}}
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
        @if($viewModel->projectGoalVM)
            <div class="col-xs-3 text-center {{ $class }}">
                @include('landingpages.partials.project-goal', ['projectGoalVM' => $viewModel->projectGoalVM])
            </div>
        @endif
    </div>
</div>
