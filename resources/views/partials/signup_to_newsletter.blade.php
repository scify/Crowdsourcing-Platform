<div class="row w-100 align-items-center mx-0" id="newsletter">
    <div class="col-md-12 p-0">
        <h2 style="color: {{ $viewModel->project->lp_primary_color }}; font-weight: bold">{{ __("questionnaire.newsletter") }}</h2>
        <div class="content-container">
            <p class="text-center">
                {{ __("questionnaire.learn_about_new_projects") }}
            </p>
            <div class="sign-up container">
                <div class="row">
                    <div class="col-md-4 col-sm-12 mx-auto">
                        <a href="https://ecas.org/#gform_wrapper_1" target="_blank"
                           class="btn btn-outline-dark signup-btn call-to-action">{{ __("questionnaire.sign_up") }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    @vite('resources/assets/js/partials/newsletter-signup.js')
@endpush
