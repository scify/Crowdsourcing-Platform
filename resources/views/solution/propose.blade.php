@extends('crowdsourcing-project.layout')
@push('header-scripts')
    <script async src="https://www.google.com/recaptcha/api.js?render={{config('services.recaptcha.key')}}"></script>
@endpush
@push('css')
    <script>
		function onSubmit(token) {
			console.log("onSubmit")
			const translationNotice = document.getElementById('translation-notice');
			const consentNotice = document.getElementById('consent-notice');
			const errorMessageDiv = document.getElementById('error-messages');
			let valid = true;
			let errorMessages = [];

			if (!translationNotice.checked) {
				errorMessages.push("{{ __('solution.translation_notice_required') }}");
				valid = false;
			}

			if (!consentNotice.checked) {
				errorMessages.push("{{ __('solution.consent_notice_required') }}");
				valid = false;
			}

			if (valid) {
				document.getElementById("solution-form").submit();
			} else {
				grecaptcha.reset();
				errorMessageDiv.innerHTML = errorMessages.join('<br>');
				errorMessageDiv.style.display = 'block';
			}
		}

		document.addEventListener('DOMContentLoaded', function () {
			document.getElementById('translation-notice').addEventListener('click', function () {
				document.getElementById('error-messages').style.display = 'none';
			});
			document.getElementById('consent-notice').addEventListener('click', function () {
				document.getElementById('error-messages').style.display = 'none';
			});
		});
    </script>
    @vite('resources/assets/sass/solution/propose-page.scss')
    <style>
        :root {
            --project-primary-color: {{ $viewModel->project->lp_primary_color}};
            --btn-text-color: {{ $viewModel->project->lp_btn_text_color_theme == "light" ? "#ffffff" : "#212529"}};
        }
    </style>
@endpush

@section('content')

    <div id="propose-solution-page" class="pb-5">

        @include('partials.flash-messages-and-errors')
        
        <section id="propose-solution-overview" class="bg-clr-primary-white">
            @include('solution.partials.propose-solution-overview')
        </section>

        <section id="propose-solution-form" class="bg-clr-primary-white bg-image-noise">
            @include('solution.partials.new-solution-form')
        </section>

    </div>

    @if (App::environment('local'))
        <div class="fixed-bottom"> <!-- bookmark1 - for use only during development -->
            <div class="alert alert-danger text-center font-weight-bold"
                 style="top: -40px; width: 160px; margin: 0 auto; opacity: 0.25">
                <div class="d-block d-sm-none">xs (default)</div>
                <div class="d-none d-sm-block d-md-none">sm</div>
                <div class="d-none d-md-block d-lg-none">md</div>
                <div class="d-none d-lg-block d-xl-none">lg</div>
                <div class="d-none d-xl-block d-custom_xxl-none">xl</div>
                <div class="d-none d-custom_xxl-block">custom_xxl</div>
            </div>
        </div>
    @endif

@endsection
