<div class="activity-title wrapper-title">
    <p>{{ $viewModel->responsesNeededToReachGoal }} answers left to reach our goal</p>
</div>
<div class="progress-container">
    <div class="progress-bar-circle" id="project-progress-{{ $projectId }}"
         data-target="{{$viewModel->targetAchievedPercentage}}">
    </div>
</div>
@push('scripts')
    <script src="{{ mix('dist/js/projectGoal.js')}}"></script>
@endpush
