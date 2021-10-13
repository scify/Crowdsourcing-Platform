<div class="activity-title wrapper-title">
    <p style="color: {{ $project->lp_questionnaire_goal_color }}">
        <b>{{ $questionnaireViewModel->responsesNeededToReachGoal }}</b> answers left to reach our goal</p>
</div>
<div class="progress-container">
    <div class="progress-bar-circle" id="project-progress-{{ $project->id }}"
         data-color="{{ $project->lp_questionnaire_goal_color }}"
         data-target="{{$questionnaireViewModel->targetAchievedPercentage}}">
    </div>
</div>
@push('scripts')
    <script src="{{ mix('dist/js/projectGoal.js')}}"></script>
@endpush
