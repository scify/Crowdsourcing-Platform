<div class="container px-sm-0">

    <div class="row">
        <div class="col-12">
            <h2 class="solution-form-title pb-2 mb-5">{{ __('solution.submission_form') }}</h2>
        </div>
    </div>

    <form id="problem-form" enctype="multipart/form-data" method="POST"
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
                        >
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
                            >{{ old('solution-description') ? old('solution-description') : '' }}</textarea>
                        <div id="solution-description-feedback" class="invalid-feedback">
                            <strong>{{ $errors->first('solution-description') }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row form-row js-image-input-container">
                <div class="col-12">
                    <div class="form-group input-file-wrapper">
                        <label for="solution-image">{{ __('solution.solution_image_label') }}
                            ({{ __('common.image_max_size') }})</label>
                        <p class="my-3">{{ __('solution.solution_image_placeholder') }}</p>
                        <small class="mb-2 d-block"> {{ __('common.image_accepted_formats') }}</small>
                        <input type="file"
                               id="solution-image"
                               name="solution-image"
                               class="form-control p-2 h-auto {{ $errors->has('solution-image') ? 'is-invalid' : '' }} js-image-input"
                               accept="image/png,image/jpeg,image/jpg,image/webp"
                               placeholder="{{ __('solution.solution_image_placeholder') }}"
                                {{ $errors->has('solution-image') ? 'aria-describedby="solution-image-feedback"' : '' }}
                        >
                        <div id="solution-image-feedback" class="invalid-feedback">
                            <strong>{{ $errors->first('solution-image') }}</strong></div>
                    </div>
                    <div class="image-preview-container">
                        <img
                                loading="lazy"
                                class="selected-image-preview js-selected-image-preview hidden"
                                src=""
                                alt="">
                    </div>
                </div>
            </div>

            <div class="row form-row">
                <div class="col-12">
                    <h4>{{ __('solution.solution_translation_notice_title') }}</h4>
                    <p>{!! __('solution.solution_translation_notice') !!}</p>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="translation-notice"
                               name="translation-notice" required>
                        <label class="form-check-label" for="translation-notice">
                            {{ __('solution.solution_translation_notice_checkbox') }} (<span
                                    class="red">*</span>)
                        </label>
                    </div>
                </div>
            </div>
            <div class="row form-row mt-4">
                <div class="col-12">
                    <h3 class="mb-4">{{ __('solution.community_guidelines_title') }}</h3>
                    <h4>{{ __('solution.quality_submissions_title') }}</h4>
                    <p>{{ __('solution.community_guidelines_intro') }}</p>
                </div>
                <div class="col-12">
                    <ul>
                        @foreach(__('solution.community_guidelines_list') as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="row form-row mt-4">
                <div class="col-12">
                    <h4>{{ __('solution.respectful_content_title') }}</h4>
                    <p>{{ __('solution.respectful_content_message') }}</p>
                </div>
                <div class="col-12">
                    <ul>
                        @foreach(__('solution.respectful_content_list') as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="row form-row">
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="consent-notice"
                               name="consent-notice" required>
                        <label class="form-check-label" for="consent-notice">
                            {!! __('solution.solution_consent_notice', [
                                'privacy_policy' => '<a href="' . route('terms.privacy') . '" target="_blank">' . __('common.terms_privacy') . '</a>',
                                'code_of_conduct' => '<a href="' . route('codeOfConduct') . '" target="_blank">' . __('common.code_of_conduct') . '</a>'
                            ]) !!} (<span
                                    class="red">*</span>)
                        </label>
                    </div>
                </div>
            </div>

        </div>

        <div>
            <div class="container-fluid p-0">
                <div class="row py-5">
                    <div class="col-12 d-flex justify-content-center">
                        <input class="btn btn-primary call-to-action" id="submit-form" type="submit"
                               value="{{ __('solution.submit_solution') }}">
                    </div>
                </div>
            </div>
        </div>


    </form>

</div>
@push('scripts')
    @vite('resources/assets/js/solution/manage-solution.js')
@endpush