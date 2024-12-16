<div class="propose-solution-cta">
    <h3 class="mb-3 text-center">
        {{ __("solution.have_a_solution_to_suggest") }}
    </h3>
    <div class="d-flex justify-content-center">
        <button type="button" title="Propose a Solution" class="btn btn-primary call-to-action align"
            onclick="let currentUrl = window.location.href; if (!currentUrl.endsWith('/')) {currentUrl += '/';} window.location.href = currentUrl + 'solutions/propose';">
            {{ __("solution.propose_solution_title") }}
        </button>
    </div>
</div>
