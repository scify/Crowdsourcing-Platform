<div class="activity-title wrapper-title mt-2">
    <p>{!! __("questionnaire.answers_left_to_goal",  ["count"=>"$questionnaireViewModel->responsesNeededToReachGoal"]) !!}
        !</p>
</div>
<div class="progress-container">
    <div class="progress-bar-circle" id="questionnaire-progress-{{ $questionnaireId }}"
         data-color="{{ $project->lp_primary_color }}"
         data-target="{{$questionnaireViewModel->targetAchievedPercentage}}">
    </div>
</div>
