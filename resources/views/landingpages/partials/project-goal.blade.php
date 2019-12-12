<div class="activity-title wrapper-title">
    <p>{{ $projectGoalVM->responsesNeededToReachGoal }} answers left to reach our goal</p>
</div>
<div class="progress-container">
    <div class="progress-bar-circle" id="project-progress-{{ $projectId }}"
         data-target="{{$projectGoalVM->targetAchievedPercentage}}">
    </div>
</div>
