<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">

<div class="form-row" style="display: none;{{-- bookmark2 --}}">
    <div class="col-sm-12 mb-3">
        <label for="validationServer04">State</label>
        <select class="custom-select is-invalid" id="validationServer04" aria-describedby="validationServer04Feedback">
            <option selected disabled value="">Choose...</option>
            <option>...</option>
        </select>
        <div id="validationServer04Feedback" class="invalid-feedback">
            Please select a valid state.
        </div>
    </div>
</div>

                <div class="form-row">
                    <div class="col-sm-12 mb-3">
                        <label for="problem-owner-project">Project the problem belongs to (<span class="red">*</span>)</label>
                        <input type="text"
                            id="problem-owner-project"
                            name="problem-owner-project"
                            class="form-control {{ $errors->has('problem-owner-project') ? 'is-invalid' : '' }}"
                            required
                            placeholder="Problem Owner-Project"
                            {{-- value="{{ old('problem-owner-project') ? old('problem-owner-project') : $viewModel->problem->project_id }}" bookmark2 --}}
                            value="{{ old('problem-owner-project') ? old('problem-owner-project') : '' }}"
                        >
                        <div class="invalid-feedback"><strong>{{ $errors->first('problem-owner-project') }}</strong></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-sm-12 mb-3">
                        <label for="problem-title">Problem Title (<span class="red">*</span>)</label>
                        <input type="text"
                            id="problem-title"
                            name="problem-title"
                            class="form-control {{ $errors->has('problem-title') ? 'is-invalid' : '' }}"
                            required
                            placeholder="Problem Title"
                            maxlength="100"
                            {{ $errors->has('problem-title') ? 'aria-describedby="problem-title-feedback"' : '' }}
                            {{-- value="{{ old('problem-title') ? old('problem-title') : $viewModel->problem->defaultTranslation->title }}" bookmark2 --}}
                            value="{{ old('problem-title') ? old('problem-title') : '' }}"
                        >
                        <div id="problem-title-feedback" class="invalid-feedback"><strong>{{ $errors->first('problem-title') }}</strong></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-sm-12 mb-3">
                        <label for="problem-description">Problem Description (<span class="red">*</span>)</label>
                        <textarea
                            id="problem-description"
                            name="problem-description"
                            class="form-control {{ $errors->has('problem-description') ? 'is-invalid' : '' }}"
                            required
                            rows="6"
                            placeholder="Problem Description"
                            maxlength="400"
                        >{{-- {{ old('problem-description') ? old('problem-description') : $viewModel->problem->defaultTranslation->description }} bookmark2 --}}{{ old('problem-description') ? old('problem-description') : '' }}</textarea>
                        <div class="invalid-feedback"><strong>{{ $errors->first('problem-description') }}</strong></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-sm-12 mb-3">
                        <label for="problem-status">Problem Status (<span class="red">*</span>)</label>
                        <input type="text"
                            id="problem-status"
                            name="problem-status"
                            class="form-control {{ $errors->has('problem-status') ? 'is-invalid' : '' }}"
                            required
                            placeholder="Problem Status"
                            {{-- value="{{ old('problem-status') ? old('problem-status') : $viewModel->problem->status_id }}" bookmark2 --}}
                            value="{{ old('problem-status') ? old('problem-status') : '' }}"
                        >
                        <div class="invalid-feedback"><strong>{{ $errors->first('problem-status') }}</strong></div>
                    </div>
                </div>

<div class="form-row" style="display: none;{{-- bookmark2 --}}">
    <div class="col-sm-12 mb-3">
        <div class="form-group">
            <label for="problem-status-2">Problem Status-2</label>
            @if(!Gate::check('manage-platform-content'))
                <small class="text-blue">(The problem status can only be changed by a platform administrator.)</small>{{-- bookmark2 - is this what we want? --}}
            @endif
            <select id="problem-status-2" class="form-control" name="problem-status-2">
                {{-- @foreach ($viewModel->problemStatusesLkp as $status) --}}
                    <option
                            @if(!Gate::allows('manage-platform-content'))
                                disabled{{-- bookmark2 - is this what we want? --}}
                            @endif
                            {{-- @if ($viewModel->problem->status_id == $status->id || old('problem-status-2') == $status->id) --}}
                                selected
                            {{-- @endif --}}
                            {{-- value="{{ $status->id }}"> --}}
                            value="1">
                        {{-- {{ $status->title }} --}}
                        Draft
                    </option>
                {{-- @endforeach --}}
            </select>
        </div>
    </div>
</div>

                <div class="form-row">
                    <div class="col-sm-12 mb-3">
                        <label for="problem-default-language">Problem Default Language (<span class="red">*</span>)</label>
                        <input type="text"
                            id="problem-default-language"
                            name="problem-default-language"
                            class="form-control {{ $errors->has('problem-default-language') ? 'is-invalid' : '' }}"
                            required
                            placeholder="Problem Default Language"
                            {{-- value="{{ old('problem-default-language') ? old('problem-default-language') : $viewModel->problem->default_language_id }}" bookmark2 --}}
                            value="{{ old('problem-default-language') ? old('problem-default-language') : '' }}"
                        >
                        <div class="invalid-feedback"><strong>{{ $errors->first('problem-default-language') }}</strong></div>
                    </div>
                </div>

<div class="form-row" style="display: none;{{-- bookmark2 --}}">
    <div class="col-sm-12 mb-3">
        <div class="form-group">
            <label for="problem-default-language-2">Problem Default Language-2</label>
            <select id="problem-default-language-2" class="form-control" name="problem-default-language-2">
                {{-- @foreach ($viewModel->languagesLkp as $language) --}}
                    <option
                            {{-- @if ($viewModel->shouldLanguageBeSelected($language)) --}}
                                selected
                            {{-- @endif --}}
                            {{-- value="{{ $language->id }}"> --}}
                            value="1">
                        {{-- {{ $language->language_name }} --}}
                        English
                    </option>
                {{-- @endforeach --}}
            </select>
        </div>
    </div>
</div>

                <div class="form-row">
                    <div class="col-sm-12 mb-3">
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
                        <div class="invalid-feedback"><strong>{{ $errors->first('problem-slug') }}</strong></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-sm-12 mb-3">
                        <label for="problem-image">Problem Image (max-size: 2MB)</label></label>
                        <input type="file"
                            id="problem-image"
                            name="problem-image"
                            class="form-control p-2 h-auto {{ $errors->has('problem-image') ? 'is-invalid' : '' }}"
                            accept="image/png,image/jpeg,image/jpg"
                            placeholder="Problem Image"
                        >
                        <div class="invalid-feedback"><strong>{{ $errors->first('problem-image') }}</strong></div>
                    </div>
                </div>

                <div class="form-row align-items-end">
                    <div class="col-auto mb-3">
                        <label for="problem-creator-user-id">Problem Creator's User-ID (<span class="red">*</span>)</label>
                        <input type="text"
                            id="problem-creator-user-id"
                            name="dummy-problem-creator-user-id"
                            class="form-control {{ $errors->has('problem-creator-user-id') ? 'is-invalid' : '' }}"
                            required
                            readonly
                            disabled
                            placeholder="Problem Creator's User-ID"
                            value="{{ Auth::user()->id }}"
                        >
                        <div class="invalid-feedback"><strong>{{ $errors->first('problem-creator-user-id') }}</strong></div>
                    </div>
                    <div class="col-auto mb-3">
                        <span>
                            ( {{ Auth::user()->nickname }}
                            <img src="{{ Auth::user()->avatar }}"
                                alt="User &quot;{{ Auth::user()->nickname }}&quot;'s avatar image"
                                style="height: 38px;"
                            >
                            )
                        </span>
                    </div>
                    <input type="hidden" name="problem-creator-user-id" value="{{ Auth::user()->id }}" autocomplete="off">
                </div>

            </div>
        </div>
    </div>
</div>
