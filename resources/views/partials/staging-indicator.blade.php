@if (App::environment('staging'))
    <div class="row mb-3 fixed-top" style="z-index: 100000">
        <div class="col p-0">
            <div class="sticky-top w-100 staging-warning py-2 text-center">
                <h5 class="m-0">~~~ WARNING: TESTING ENVIRONMENT ~~~</h5>
            </div>
        </div>
    </div>
@endif
