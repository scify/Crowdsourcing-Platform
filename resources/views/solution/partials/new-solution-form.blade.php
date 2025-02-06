<div class="container px-sm-0">

    <div class="row">
        <div class="col-12">
            <h2 class="solution-form-title pb-2 mb-5">{{ __('solution.submission_form') }}</h2>
        </div>
    </div>

    <form id="solution-form" enctype="multipart/form-data" method="POST"
          action="{{ route('solutions.user-proposal-store', [request('project_slug'), request('problem_slug')]) }}">

        @csrf

        <div class="container-fluid p-0">

            <div class="row form-row">
                <div class="col-12">

                    <input type="hidden" name="solution-owner-problem" value="{{ $viewModel->problem->id }}">
                    <div class="solution-language-notifier my-4">
                        <h4>
                            {{ __('solution.solution_language_message') }}:
                            <b>{{ $viewModel->language->language_name }}</b>
                        </h4>
                    </div>
                </div>
            </div>

            <div class="row form-row">
                <div class="col-12">
                    <div class="form-group">
                        <small class="d-block mb-2">{{ __('common.form_fields_required') }}</small>
                        <label for="solution-title">{{ __('solution.solution_title_label') }} (<span
                                    class="red">*</span>)</label>
                        <input type="text"
                               id="solution-title"
                               name="solution-title"
                               class="form-control {{ $errors->has('solution-title') ? 'is-invalid' : '' }}"
                               required
                               placeholder="{{ __('solution.solution_title_placeholder') }}"
                               maxlength="100"
                               {{ $errors->has('solution-title') ? 'aria-describedby="solution-title-feedback"' : '' }}
                               value="{{ old('solution-title') ? old('solution-title') : '' }}"
                               oninput="updateCharCount('solution-title', 100)"
                        >
                        <small id="solution-title-count"
                               class="form-text text-muted">100 {{ __('solution.characters_left') }}</small>
                        <div id="solution-title-feedback" class="invalid-feedback">
                            <strong>{{ $errors->first('solution-title') }}</strong></div>
                    </div>
                </div>
            </div>

            <div class="row form-row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="solution-description">{{ __('solution.solution_description_label') }} (<span
                                    class="red">*</span>)</label>
                        <textarea
                                id="solution-description"
                                name="solution-description"
                                class="form-control {{ $errors->has('solution-description') ? 'is-invalid' : '' }}"
                                required
                                rows="6"
                                placeholder="{{ __('solution.solution_description_placeholder') }}"
                                maxlength="400"
                                {{ $errors->has('solution-description') ? 'aria-describedby="solution-description-feedback"' : '' }}
                                oninput="updateCharCount('solution-description', 400)"
                        >{{ old('solution-description') ? old('solution-description') : '' }}</textarea>
                        <small id="solution-description-count"
                               class="form-text text-muted">400 {{ __('solution.characters_left') }}</small>
                        <div id="solution-description-feedback" class="invalid-feedback">
                            <strong>{{ $errors->first('solution-description') }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rest of the form -->

        </div>

        <div>
            <div class="container-fluid p-0">
                <div class="row py-5">
                    <div class="col-12 d-flex justify-content-center">
                        <button class="btn btn-primary call-to-action g-recaptcha" id="submit-form" type="submit"
                                data-sitekey="{{ config('services.recaptcha.key') }}"
                                data-callback="onSubmit"
                                data-action="submitSolution"
                        >{{ __('solution.submit_solution') }}</button>
                    </div>
                </div>
            </div>
        </div>

    </form>

</div>
@push('scripts')
    @vite('resources/assets/js/solution/manage-solution.js')
    <script>
		const charactersLeftMessage = "{{ __('solution.characters_left') }}";

		function updateCharCount(fieldId, maxChars) {
			const field = document.getElementById(fieldId);
			const countField = document.getElementById(fieldId + "-count");
			const remainingChars = maxChars - field.value.length;
			countField.textContent = remainingChars + " " + charactersLeftMessage;
		}
    </script>
@endpush