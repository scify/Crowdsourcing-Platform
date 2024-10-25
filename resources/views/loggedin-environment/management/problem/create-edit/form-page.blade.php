Problems
<pre>
0 => "id"
1 => "project_id"
2 => "slug"
3 => "status_id"
4 => "img_url"
5 => "default_language_id"

?? => "user_creator_id"

defaultTranslation(): HasOne
translations(): HasMany
</pre>

ProblemTranslations
<pre>
0 => "problem_id"
1 => "language_id"
2 => "title"
3 => "description"

problem(): BelongsTo
language(): BelongsTo
</pre>

{{--
<form id="problem-form" enctype="multipart/form-data" method="POST"
    action="{{ $viewModel->isEditMode() ? route('problems.update', $viewModel->problem) : route('problems.store') }}">
--}}

<form id="problem-form" enctype="multipart/form-data"{{-- bookmark2 - enctype? --}} method="POST"
    action="{{ route('problems.store') }}">

{{--
    @if($viewModel->isEditMode())
        @method('PUT')
    @endif
--}}

    @csrf

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="row">
                            <label class="col-sm-12 control-label" for="problem-title">Problem Title (<span class="red">*</span>)</label>
                            <div class="col-sm-12">
                                <div class="form-group has-feedback {{ $errors->has('problem-title') ? 'has-error' : '' }}">
                                    <input type="text"
                                        id="problem-title"
                                        name="problem-title"
                                        class="form-control"
                                        required
                                        placeholder="Problem Title"
                                        {{-- value="{{ old('problem-title') ? old('problem-title') : $viewModel->problem->defaultTranslation->title }}" bookmark2 --}}
                                        value="{{ old('problem-title') ? old('problem-title') : '' }}"
                                    >
                                    <span class="help-block"><strong>{{ $errors->first('problem-title') }}</strong></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-12 control-label" for="problem-description">Problem Description (<span class="red">*</span>)</label>
                            <div class="col-sm-12">
                                <div class="form-group has-feedback {{ $errors->has('problem-description') ? 'has-error' : '' }}">
                                    <textarea
                                        id="problem-description"
                                        name="problem-description"
                                        class="form-control"
                                        required
                                        rows="6"
                                        placeholder="Problem Description"
                                    >{{-- {{ old('problem-description') ? old('problem-description') : $viewModel->problem->defaultTranslation->description }} bookmark2 --}}{{ old('problem-description') ? old('problem-description') : '' }}</textarea>
                                    <span class="help-block"><strong>{{ $errors->first('problem-description') }}</strong></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-12 control-label" for="problem-status">Problem Status (<span class="red">*</span>)</label>
                            <div class="col-sm-12">
                                <div class="form-group has-feedback {{ $errors->has('problem-status') ? 'has-error' : '' }}">
                                    <input type="text"
                                        id="problem-status"
                                        name="problem-status"
                                        class="form-control"
                                        required
                                        placeholder="Problem Status"
                                        {{-- value="{{ old('problem-status') ? old('problem-status') : $viewModel->problem->status_id }}" bookmark2 --}}
                                        value="{{ old('problem-status') ? old('problem-status') : '' }}"
                                    >
                                    <span class="help-block"><strong>{{ $errors->first('problem-status') }}</strong></span>
                                </div>
                            </div>
                        </div>
                        
<div class="row" style="display: none;{{-- bookmark2 --}}">
    <div class="col-md-12">
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

                        <div class="row">
                            <label class="col-sm-12 control-label" for="problem-default-language">Problem Default Language (<span class="red">*</span>)</label>
                            <div class="col-sm-12">
                                <div class="form-group has-feedback {{ $errors->has('problem-default-language') ? 'has-error' : '' }}">
                                    <input type="text"
                                        id="problem-default-language"
                                        name="problem-default-language"
                                        class="form-control"
                                        required
                                        placeholder="Problem Default Language"
                                        {{-- value="{{ old('problem-default-language') ? old('problem-default-language') : $viewModel->problem->default_language_id }}" bookmark2 --}}
                                        value="{{ old('problem-default-language') ? old('problem-default-language') : '' }}"
                                    >
                                    <span class="help-block"><strong>{{ $errors->first('problem-default-language') }}</strong></span>
                                </div>
                            </div>
                        </div>

<div class="row" style="display: none;{{-- bookmark2 --}}">
    <div class="col-md-12">
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

                        <div class="row">
                            <label class="col-md-12{{-- bookmark2 - md here? or sm? --}} control-label" for="problem-slug">Problem Slug (<span class="red">*</span>)
                                <br>(it defines the problems's url, for example:
                                <br><i>For english | https://crowdsourcing.ecas.org/en/your-problem-slug</i>)
                                <br><i>For greek | https://crowdsourcing.ecas.org/gr/your-problem-slug</i>)
                                <br><i>For dutch | https://crowdsourcing.ecas.org/nl/your-problem-slug</i>)
                                <br>The url can contain only letters, numbers, and dashes.
                                <br>If left empty, we will take care of creating the URL, based on the problem name. {{-- bookmark2 - implement auto-creation - best done with js (client-side) --}}
                                <br>Please note that once you publish the problem you <i>cannot</i> change the slug. {{-- bookmark2 - once published or once created? --}}
                            </label>
                            <div class="col-sm-12">
                                <div class="form-group has-feedback {{ $errors->has('problem-slug') ? 'has-error' : '' }}">
                                    <input type="text"
                                        id="problem-slug"
                                        name="problem-slug"
                                        class="form-control"
                                        required
                                        placeholder="Problem Slug"
                                        {{-- value="{{ old('problem-slug') ? old('problem-slug') : $viewModel->problem->slug }}" bookmark2 --}}
                                        value="{{ old('problem-slug') ? old('problem-slug') : ''  }}"
                                    >
                                    <span class="help-block"><strong>{{ $errors->first('problem-slug') }}</strong></span>
                                </div>
                            </div>
                        </div>

                        <input type="submit">

                    </div>
                </div>
            </div>
        </div>
    </div>

</form>
