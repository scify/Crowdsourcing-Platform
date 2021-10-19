<div class="row w-100 align-items-center mx-0" id="newsletter">
    <div class="col-md-12 p-0">
        <h2 style="color: {{ $viewModel->project->lp_primary_color }}; font-weight: bold">Newsletter</h2>
        <div class="content-container">
            <p class="text-center">
                Learn about all our new projects, get updates on active ones and contribute where it is most
                needed!
            </p>
            <div class="sign-up row">
                <div class="col-md-3 call-to-action" style="float: none; margin: 0 auto;">
                    <a href="https://ecas.org/#mc_signup" target="_blank"
                       class="btn btn-block btn-outline-dark signup-btn">Sign up!</a>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script src="{{mix('dist/js/newsletter-signup.js')}}"></script>
@endpush
