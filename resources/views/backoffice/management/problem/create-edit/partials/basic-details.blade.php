<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">

                <div class="form-row">
                    <div class="form-group col-sm-12">
                        <label for="problem-owner-project">Project the problem belongs to (<span
                                    class="red">*</span>)</label>
                        <select
                                id="problem-owner-project"
                                name="problem-owner-project"
                                class="form-control {{ $errors->has('problem-owner-project') ? 'is-invalid' : '' }}"
                                required
                                {{ $errors->has('problem-owner-project') ? 'aria-describedby="problem-owner-project-feedback"' : '' }}
                        >
                            <option disabled selected value="">Choose...</option>
                            @foreach ($viewModel->projects as $project)
                                <option
                                        @if ($viewModel->problem->project_id == $project->id || old('problem-owner-project') == $project->id)
                                            selected
                                        @endif
                                        value="{{ $project->id }}"
                                >
                                    {{ $project->defaultTranslation->name }}
                                </option>
                            @endforeach
                        </select>
                        <div id="problem-owner-project-feedback" class="invalid-feedback">
                            <strong>{{ $errors->first('problem-owner-project') }}</strong></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm-12">
                        <label for="problem-default-language">Problem Default Language (<span
                                    class="red">*</span>)</label>
                        <select
                                id="problem-default-language"
                                name="problem-default-language"
                                class="form-control {{ $errors->has('problem-default-language') ? 'is-invalid' : '' }}"
                                required
                        >
                            @foreach ($viewModel->languagesLkp as $language)
                                <option
                                        @if ($viewModel->shouldLanguageBeSelected($language))
                                            selected
                                        @endif
                                        value="{{ $language->id }}"
                                >
                                    {{ $language->language_name }}
                                </option>
                            @endforeach
                        </select>
                        <div id="problem-default-language-feedback" class="invalid-feedback">
                            <strong>{{ $errors->first('problem-default-language') }}</strong></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm-12">
                        <label class="m-0" for="problem-title">Problem Title (<span class="red">*</span>)</label>
                        <span class="text-sm explanation-text ml-0 mb-2">
                            (The title should be concise and descriptive, under <b>100</b> characters.)
                        </span>
                        <input type="text"
                               id="problem-title"
                               name="problem-title"
                               class="form-control {{ $errors->has('problem-title') ? 'is-invalid' : '' }}"
                               required
                               placeholder="Problem Title"
                               maxlength="100"
                               {{ $errors->has('problem-title') ? 'aria-describedby="problem-title-feedback"' : '' }}
                               value="{{ old('problem-title') ? old('problem-title') : $viewModel->problem->defaultTranslation->title }}"
                        >
                        <div id="problem-title-feedback" class="invalid-feedback">
                            <strong>{{ $errors->first('problem-title') }}</strong></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm-12">
                        <label class="m-0" for="problem-description">Problem Description (<span
                                    class="red">*</span>)</label>
                        <span class="text-sm explanation-text ml-0 mb-2">
                            (The description should be concise and descriptive, under <b>600</b> characters.)
                        </span>
                        <textarea
                                id="problem-description"
                                name="problem-description"
                                class="form-control {{ $errors->has('problem-description') ? 'is-invalid' : '' }}"
                                required
                                rows="5"
                                placeholder="Problem Description"
                                maxlength="600"
                            {{ $errors->has('problem-description') ? 'aria-describedby="problem-description-feedback"' : '' }}
                        >{{ old('problem-description') ? old('problem-description') : $viewModel->problem->defaultTranslation->description }}</textarea>
                        <div id="problem-description-feedback" class="invalid-feedback">
                            <strong>{{ $errors->first('problem-description') }}</strong></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm-12">
                        <label for="problem-status">Problem Status (<span class="red">*</span>)</label>
                        <select
                                id="problem-status"
                                name="problem-status"
                                class="form-control {{ $errors->has('problem-status') ? 'is-invalid' : '' }}"
                                required
                                {{ $errors->has('problem-status') ? 'aria-describedby="problem-status-feedback"' : '' }}
                        >
                            @foreach ($viewModel->problemStatusesLkp as $status)
                                <option
                                        @if ($viewModel->problem->status_id == $status->id || old('problem-status') == $status->id)
                                            selected
                                        @endif
                                        value="{{ $status->id }}"
                                >
                                    {{ $status->title }}
                                </option>
                            @endforeach
                        </select>
                        <div id="problem-status-feedback" class="invalid-feedback">
                            <strong>{{ $errors->first('problem-status') }}</strong></div>
                    </div>
                </div>

                @if($viewModel->isEditMode())
                    <div class="form-row">
                        <div class="form-group col-sm-12">
                            <label for="problem-slug">Problem Slug (<span class="red">*</span>)
                                <span class="text-sm explanation-text">
                                    (It defines the problems's url, for example:
                                    <ul>
                                        <li><i>For english | https://crowdsourcing.ecas.org/en/project-slug/problem-slug</i></li>
                                        <li><i>For greek | https://crowdsourcing.ecas.org/gr/project-slug/problem-slug</i></li>
                                        <li><i>For dutch | https://crowdsourcing.ecas.org/nl/project-slug/problem-slug</i></li>
                                    </ul>
                                    The slug must be unique and can contain only letters, numbers, and dashes.)
                                </span>
                            </label>
                            <input type="text"
                                   id="problem-slug"
                                   name="problem-slug"
                                   class="form-control {{ $errors->has('problem-slug') ? 'is-invalid' : '' }}"
                                   required
                                   placeholder="Problem Slug"
                                   maxlength="111"
                                   value="{{ old('problem-slug') ? old('problem-slug') : $viewModel->problem->slug }}"
                            >
                            <div id="problem-slug-feedback" class="invalid-feedback">
                                <strong>{{ $errors->first('problem-slug') }}</strong></div>
                        </div>
                    </div>
                @endif

                <div class="form-row js-image-input-container">
                    <div class="col-sm-12">
                        <div class="form-group input-file-wrapper">
                            <label for="problem-image">Problem Image (max-size: 2MB)
                                <span class="text-sm explanation-text">
                                    In order to update the currently selected image, please choose a new image by
                                clicking the button below.
                                </span>
                            </label>
                            <input type="file"
                                   id="problem-image"
                                   name="problem-image"
                                   class="form-control p-2 h-auto {{ $errors->has('problem-image') ? 'is-invalid' : '' }} js-image-input"
                                   accept="image/png,image/jpeg,image/jpg,image/webp"
                                   placeholder="Problem Image"
                            >
                            <div id="problem-image-feedback" class="invalid-feedback">
                                <strong>{{ $errors->first('problem-image') }}</strong></div>
                        </div>
                        <div class="image-preview-container">
                            <img
                                    loading="lazy"
                                    class="selected-image-preview js-selected-image-preview"
                                    src="{{ $viewModel->problem->img_url ? asset($viewModel->problem->img_url) : '/images/problem_default_image.png' }}"
                                    alt="">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
