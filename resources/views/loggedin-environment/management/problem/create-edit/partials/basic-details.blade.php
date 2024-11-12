<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">

                <div class="form-row">
                    <div class="form-group col-sm-12">
                        <label for="problem-owner-project">Project the problem belongs to (<span class="red">*</span>)</label>
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
                        <div id="problem-owner-project-feedback" class="invalid-feedback"><strong>{{ $errors->first('problem-owner-project') }}</strong></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm-12">
                        <label for="problem-title">Problem Title (<span class="red">*</span>)</label>
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
                        <div id="problem-title-feedback" class="invalid-feedback"><strong>{{ $errors->first('problem-title') }}</strong></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm-12">
                        <label for="problem-description">Problem Description (<span class="red">*</span>)</label>
                        <textarea
                            id="problem-description"
                            name="problem-description"
                            class="form-control {{ $errors->has('problem-description') ? 'is-invalid' : '' }}"
                            required
                            rows="6"
                            placeholder="Problem Description"
                            maxlength="400"
                            {{ $errors->has('problem-description') ? 'aria-describedby="problem-description-feedback"' : '' }}
                        >{{ old('problem-description') ? old('problem-description') : $viewModel->problem->defaultTranslation->description }}</textarea>
                        <div id="problem-description-feedback" class="invalid-feedback"><strong>{{ $errors->first('problem-description') }}</strong></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm-12">
                        <label for="problem-status">Problem Status (<span class="red">*</span>)</label>
                        @if(!Gate::check('manage-platform-content'))
                            <small class="text-blue">(The problem status can only be changed by a platform administrator.)</small>{{-- bookmark2 - is this what we want? --}}
                        @endif
                        <select
                            id="problem-status"
                            name="problem-status"
                            class="form-control {{ $errors->has('problem-status') ? 'is-invalid' : '' }}"
                            required
                            {{ $errors->has('problem-status') ? 'aria-describedby="problem-status-feedback"' : '' }}
                        >
                            @foreach ($viewModel->problemStatusesLkp as $status)
                                <option
                                    @if(!Gate::check('manage-platform-content'))
                                        disabled{{-- bookmark2 - is this what we want? --}}
                                    @endif
                                    @if ($viewModel->problem->status_id == $status->id || old('problem-status') == $status->id)
                                        selected
                                    @endif
                                    value="{{ $status->id }}"
                                >
                                    {{ $status->title }}
                                </option>
                            @endforeach
                        </select>
                        <div id="problem-status-feedback" class="invalid-feedback"><strong>{{ $errors->first('problem-status') }}</strong></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm-12">
                        <label for="problem-default-language">Problem Default Language (<span class="red">*</span>)</label>
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
                        <div id="problem-default-language-feedback" class="invalid-feedback"><strong>{{ $errors->first('problem-default-language') }}</strong></div>
                    </div>
                </div>

                @if($viewModel->isEditMode())
                    <div class="form-row">
                        <div class="form-group col-sm-12">
                            <label for="problem-slug">Problem Slug (<span class="red">*</span>)
                                <span class="text-sm">
                                    <br>(it defines the problems's url, for example:
                                    <br><i>For english | https://crowdsourcing.ecas.org/en/your-problem-slug</i>)
                                    <br><i>For greek | https://crowdsourcing.ecas.org/gr/your-problem-slug</i>)
                                    <br><i>For dutch | https://crowdsourcing.ecas.org/nl/your-problem-slug</i>)
                                    <br>The url can contain only letters, numbers, and dashes.
                                    <br>If left empty, we will take care of creating the URL, based on the problem name. {{-- bookmark2 - implement auto-creation - best done with js (client-side) --}}
                                    <br>Please note that once you publish the problem you <i>cannot</i> change the slug. {{-- bookmark2 - once published or once created? --}}
                                </span>
                            </label>
                            <input type="text"
                                id="problem-slug"
                                name="problem-slug"
                                class="form-control {{ $errors->has('problem-slug') ? 'is-invalid' : '' }}"
                                required
                                placeholder="Problem Slug"
                                {{-- value="{{ old('problem-slug') ? old('problem-slug') : $viewModel->problem->slug }}" bookmark2 --}}
                                value="{{ old('problem-slug') ? old('problem-slug') : ''  }}"
                            >
                            <div id="problem-slug-feedback" class="invalid-feedback"><strong>{{ $errors->first('problem-slug') }}</strong></div>
                        </div>
                    </div>
                @endif

                <div class="form-row">
                    <div class="form-group col-sm-12">
                        <label for="problem-image">Problem Image (max-size: 2MB)</label></label>
                        <input type="file"
                            id="problem-image"
                            name="problem-image"
                            class="form-control p-2 h-auto {{ $errors->has('problem-image') ? 'is-invalid' : '' }}"
                            accept="image/png,image/jpeg,image/jpg"
                            placeholder="Problem Image"
                        >
                        <div id="problem-image-feedback" class="invalid-feedback"><strong>{{ $errors->first('problem-image') }}</strong></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
