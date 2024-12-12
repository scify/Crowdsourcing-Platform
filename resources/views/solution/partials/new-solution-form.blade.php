<div class="container px-sm-0">

    <div class="row">
        <div class="col-12">
            <h2>{{ __('solution.submission_form') }}</h2>
        </div>
    </div>

    <form id="problem-form" enctype="multipart/form-data" method="POST" action="{{ route('solutions.user-proposal-store', [request('project_slug'), request('problem_slug')]) }}">

        @csrf

        <div class="container-fluid p-0">

            <div class="row">
                <div class="col-sm-12">

                    <input type="hidden" name="solution-owner-problem" value="{{auth()->user()->id}}">

                    <div class="solution-language-notifier">
                        The language for this solution is: {{ $viewModel->language->language_name }}
                    </div>

                    <div class="form-row">
                        <div class="form-group col-sm-12">
                            <label for="solution-title">Solution Title (<span class="red">*</span>)</label>
                            <input type="text"
                                    id="solution-title"
                                    name="solution-title"
                                    class="form-control {{ $errors->has('solution-title') ? 'is-invalid' : '' }}"
                                    required
                                    placeholder="Solution Title"
                                    maxlength="100"
                                    {{ $errors->has('solution-title') ? 'aria-describedby="solution-title-feedback"' : '' }}
                                    value="{{ old('solution-title') ? old('solution-title') : '' }}"
                            >
                            <div id="solution-title-feedback" class="invalid-feedback">
                                <strong>{{ $errors->first('solution-title') }}</strong></div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-sm-12">
                            <label for="solution-description">Solution Description (<span
                                        class="red">*</span>)</label>
                            <textarea
                                    id="solution-description"
                                    name="solution-description"
                                    class="form-control {{ $errors->has('solution-description') ? 'is-invalid' : '' }}"
                                    required
                                    rows="6"
                                    placeholder="Solution Description"
                                    maxlength="400"
                                {{ $errors->has('solution-description') ? 'aria-describedby="solution-description-feedback"' : '' }}
                            >{{ old('solution-description') ? old('solution-description') : '' }}</textarea>
                            <div id="solution-description-feedback" class="invalid-feedback">
                                <strong>{{ $errors->first('solution-description') }}</strong></div>
                        </div>
                    </div>

                    <div class="form-row js-image-input-container">
                        <div class="col-sm-12">
                            <div class="form-group input-file-wrapper">
                                <label for="solution-image">Solution Image (max-size: 2MB)</label></label>
                                <br><small>In order to update the currently selected image, please choose a new image by
                                    clicking the button below.</small><br> {{-- bookmark3 - fix spacing --}}
                                <input type="file"
                                        id="solution-image"
                                        name="solution-image"
                                        class="form-control p-2 h-auto {{ $errors->has('solution-image') ? 'is-invalid' : '' }} js-image-input"
                                        accept="image/png,image/jpeg,image/jpg,image/webp"
                                        placeholder="Solution Image"
                                >
                                <div id="solution-image-feedback" class="invalid-feedback">
                                    <strong>{{ $errors->first('solution-image') }}</strong></div>
                            </div>
                            <div class="image-preview-container">
                                <img
                                        loading="lazy"
                                        class="selected-image-preview js-selected-image-preview"
                                        src="/images/solution_default_image.png"
                                        alt="">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div>
                <div class="container-fluid p-0">
                    <div class="row p-0">
                        <div class="col-lg-2 col-md-3 col-sm-12">
                            <input class="btn btn-primary btn-slim w-100 mb-3" id="submit-form" type="submit" value="Save">
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </form>

</div>
