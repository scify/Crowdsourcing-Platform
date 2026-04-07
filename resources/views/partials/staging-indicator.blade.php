@if (App::environment('staging'))
<div class="fixed-top w-100 staging-banner" style="z-index: 100000;">
    <div class="staging-banner__inner d-flex justify-content-center align-items-center py-1 px-3">
        <span class="staging-banner__pulse mr-2"></span>
        <i class="fas fa-flask mr-2" aria-hidden="true"></i>
        <span class="staging-banner__title font-weight-bold text-uppercase mr-2">
            Staging / Demo Environment
        </span>
        <span class="staging-banner__subtitle d-none d-sm-inline">
            &mdash; Not for public use &mdash; Demo data only
        </span>
    </div>
</div>
@endif
