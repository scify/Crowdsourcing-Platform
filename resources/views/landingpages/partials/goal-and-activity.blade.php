<div class="container py-5">

    <div class="goal-title">
        <h2 class="info">
            @if ($viewModel->totalResponses==0)
                {{ __("questionnaire.zero_answers") }}
            @else
                <span style="color: {{ $viewModel->project->lp_primary_color }}" class="number"><b>{{$viewModel->totalResponses}}</b></span> {{ __("questionnaire.answers_so_far") }} <b>{{$viewModel->questionnaire->goal}}</b>!
            @endif
        </h2>
    </div>

    <div class="row activity-container wrapper-box py-5 bg-white">
        <div class="col-md-6 col-sm-12 text-center" style="border-right: 1px solid {{ $viewModel->project->lp_primary_color }}">
            @if ($viewModel->totalResponses ==0)
                <p class="no-activity-found-msg"
                   style="color: {{ $viewModel->project->lp_primary_color }}">
                    {{ __("questionnaire.no_recent_activity") }}
                </p>
            @elseif ($viewModel->totalResponses > 0)
                <div class="activity-title wrapper-title">
                    <p style="color: {{ $viewModel->project->lp_primary_color }}">{{ __("questionnaire.latest_contributors") }}</p>
                </div>
                <div class="activity-content">
                    @foreach($viewModel->allResponses as $response)
                        @if($response->user_name)
                            <div class="activity-item text-left">
                                <i style="color: {{ $viewModel->project->lp_primary_color }}"
                                   class="fa fa-user-circle user-icon" aria-hidden="true"></i>
                                @if($response->created_at)
                                  {!! __("questionnaire.name_and_date_of_last_contributors", [ "name"=>"<b> $response->user_name </b>", "date" => \Carbon\Carbon::parse($response->created_at)->format('F d, Y')])!!} 
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif

        </div>

        @if($viewModel->questionnaireGoalVM)
            <div class="col-md-6 col-sm-12 text-center center}">
                @include('landingpages.partials.project-goal', ['questionnaireViewModel' => $viewModel->questionnaireGoalVM, 'project' => $viewModel->project, 'questionnaireId' => $viewModel->questionnaire->id])
            </div>
        @endif
    </div>
</div>
