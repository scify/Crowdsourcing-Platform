<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">

                <div class="solution-default-language-notifier">
                    The default language for this solution is: {{ $viewModel->problem->defaultTranslation->language->language_name }}
                </div>

                <div class="form-row">
                    <div class="form-group col-sm-12">
                        <label for="solution-title">Solution Default Title (<span class="red">*</span>)</label>
                        <input type="text"
                               id="solution-title"
                               name="solution-title"
                               class="form-control {{ $errors->has('solution-title') ? 'is-invalid' : '' }}"
                               required
                               placeholder="Solution Title"
                               maxlength="100"
                               {{ $errors->has('solution-title') ? 'aria-describedby="solution-title-feedback"' : '' }}
                               value="{{ old('solution-title') ? old('solution-title') : $viewModel->solution->defaultTranslation->title }}"
                        >
                        <div id="solution-title-feedback" class="invalid-feedback">
                            <strong>{{ $errors->first('solution-title') }}</strong></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm-12">
                        <label for="solution-description">Solution Default Description (<span
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
                        >{{ old('solution-description') ? old('solution-description') : $viewModel->solution->defaultTranslation->description }}</textarea>
                        <div id="solution-description-feedback" class="invalid-feedback">
                            <strong>{{ $errors->first('solution-description') }}</strong></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm-12">
                        <label for="solution-status">Solution Status (<span class="red">*</span>)</label>
                        <select
                                id="solution-status"
                                name="solution-status"
                                class="form-control {{ $errors->has('solution-status') ? 'is-invalid' : '' }}"
                                required
                                {{ $errors->has('solution-status') ? 'aria-describedby="solution-status-feedback"' : '' }}
                        >
                            @foreach ($viewModel->solutionStatusesLkp as $status)
                                <option
                                        @if ($viewModel->solution->status_id == $status->id || old('solution-status') == $status->id)
                                            selected
                                        @elseif ($viewModel->isStatusTheDefault($status->id))
                                            selected
                                        @endif
                                        value="{{ $status->id }}"
                                >
                                    {{ $status->title }}
                                </option>
                            @endforeach
                        </select>
                        <div id="solution-status-feedback" class="invalid-feedback">
                            <strong>{{ $errors->first('solution-status') }}</strong></div>
                    </div>
                </div>

                @if($viewModel->isEditMode())
                    <div class="form-row">
                        <div class="form-group col-sm-12">
                            <label for="solution-slug">Solution Slug (<span class="red">*</span>)
                                <span class="text-sm explanation-text">
                                    (It defines the solutions's url, for example:
                                    <ul>
                                        <li><i>For english | https://crowdsourcing.ecas.org/en/project-slug/problem-slug/solution-slug</i></li>
                                        <li><i>For greek | https://crowdsourcing.ecas.org/gr/project-slug/problem-slug/solution-slug</i></li>
                                        <li><i>For dutch | https://crowdsourcing.ecas.org/nl/project-slug/problem-slug/solution-slug</i></li>
                                    </ul>
                                    The slug must be unique and can contain only letters, numbers, and dashes.)
                                </span>
                            </label>
                            <input type="text"
                                   id="solution-slug"
                                   name="solution-slug"
                                   class="form-control {{ $errors->has('solution-slug') ? 'is-invalid' : '' }}"
                                   required
                                   placeholder="Solution Slug"
                                   maxlength="111"
                                   value="{{ old('solution-slug') ? old('solution-slug') : $viewModel->solution->slug }}"
                            >
                            <div id="solution-slug-feedback" class="invalid-feedback">
                                <strong>{{ $errors->first('solution-slug') }}</strong></div>
                        </div>
                    </div>
                @endif

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
                                    src="{{ $viewModel->solution->img_url ? asset($viewModel->solution->img_url) : '/images/solution_default_image.png' }}" {{-- bookmark3 - add solution_default_image.png --}}
                                    alt="">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
