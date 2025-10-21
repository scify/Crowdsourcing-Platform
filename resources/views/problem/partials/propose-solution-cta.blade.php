<div class="propose-solution-cta">
    <h3 class="mb-3 text-center">
        {{ __("solution.have_a_solution_to_suggest") }}
    </h3>
    <div class="d-flex justify-content-center">
        <button type="button" 
            title="{{ $project->solution_submission_open ? 'Propose a Solution' : 'Solutions submission is closed' }}"
            class="btn {{ $project->solution_submission_open ? 'btn-primary' : 'btn-secondary' }} call-to-action align"
            {{ $project->solution_submission_open ? '' : 'disabled' }}
            @if($project->solution_submission_open)
                onclick="let currentUrl = window.location.href; if (!currentUrl.endsWith('/')) {currentUrl += '/';} window.location.href = currentUrl + 'solutions/propose';"
            @endif>
            {{ $project->solution_submission_open ? __("solution.propose_solution_title") : __("solution.submission_closed") }}
        </button>
    </div>
</div>
