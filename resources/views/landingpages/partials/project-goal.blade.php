<div class="activity-title wrapper-title">
    <p>          {!! __("questionnaire.answers_left_to_goal",  ["count"=>"<b> $questionnaireViewModel->responsesNeededToReachGoal </b>"]) !!}</p>
</div>
<div class="progress-container">
    <div class="progress-bar-circle" id="questionnaire-progress-{{ $questionnaireId }}"
         data-color="{{ $project->lp_primary_color }}"
         data-target="{{$questionnaireViewModel->targetAchievedPercentage}}">
    </div>
</div>
@push('scripts')
    <script src="{{ mix('dist/js/projectGoal.js')}}"></script>
@endpush


