<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row image-input-container">
                    <label for="projectLogo" class="col-sm-12 control-label">Project Logo</label>
                    <div class="col-sm-12">
                        <div class="form-group has-feedback input-file-wrapper">
                            <small class="control-label"> In order to update the currently selected image, please
                                choose a new image by
                                clicking the button below.</small><Br>

                            <input id="projectLogo" type="file" name="logo" class="image-input" accept="image/*">
                            <span class="help-block"><strong>{{ $errors->first('logo') }}</strong></span>
                        </div>
                        <div class="image-preview-container">
                            <img loading="lazy" class="selected-image-preview"
                                 src="{{asset($viewModel->project->logo_path)}}"
                                 alt="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="status_id">Project status</label>

                            <small class="text-blue">(The project status can only be changed by a platform
                                administrator.)</small>
                            <select id="status_id" class="form-control" name="status_id">
                                @foreach ($viewModel->projectStatusesLkp as $status)
                                    <option
                                            @if ($viewModel->project->status_id == $status->id || old('status_id') == $status->id)
                                                selected
                                            @endif
                                            value="{{ $status->id }}">
                                        {{ $status->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <br>
                </div>
                <div class="row">
                    <label class="col-md-12 control-label" for="slug">Project Slug <br>(it defines the
                        project's url,
                        for example:<br>
                        <i>For english | https://crowdsourcing.ecas.org/en/your-project-slug</i>)<br>
                        <i>For greek | https://crowdsourcing.ecas.org/gr/your-project-slug</i>)<br>
                        <i>For dutch | https://crowdsourcing.ecas.org/nl/your-project-slug</i>)<br>

                        The url can contain only letters, numbers, and dashes.<br>
                        If left empty, we will take care of creating the URL, based on the project name.<br>
                        Please note that once you publish the project you <i>cannot</i> change the slug.
                    </label>
                    <div class="col-sm-12">

                        <div class="form-group has-feedback {{ $errors->has('slug') ? 'has-error' : '' }}">
                            <input id="slug" type="text" class="form-control" name="slug"
                                   value="{{ old('slug') ? old('slug') : $viewModel->project->slug  }}"
                                   placeholder="Project Slug">
                            <span class="help-block"><strong>{{ $errors->first('slug') }}</strong></span>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <label class="col-md-12 control-label" for="slug">Project External URL <br>
                        This URL will be visible to the project page once the project is finalized.<br>
                        It can be a URL to an external website or resource.
                    </label>
                    <div class="col-sm-12">

                        <div class="form-group has-feedback {{ $errors->has('external_url') ? 'has-error' : '' }}">
                            <input id="external_url" type="text" class="form-control" name="external_url"
                                   value="{{ old('external_url') ? old('external_url') : $viewModel->project->external_url  }}"
                                   placeholder="Project External URL">
                            <span class="help-block"><strong>{{ $errors->first('external_url') }}</strong></span>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="default_lang_id">Project Default Language</label>
                            <select id="default_lang_id" class="form-control" name="language_id">
                                @foreach ($viewModel->languagesLkp as $language)
                                    <option
                                            @if ($viewModel->shouldLanguageBeSelected($language))
                                                selected
                                            @endif
                                            value="{{ $language->id }}">
                                        {{ $language->language_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <br>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="max_votes_per_user_for_solutions">
                                Number of votes per user (for solutions)
                            </label>
                            <input id="max_votes_per_user_for_solutions" type="number" class="form-control"
                                   name="max_votes_per_user_for_solutions"
                                   value="{{ old('max_votes_per_user_for_solutions') ? old('max_votes_per_user_for_solutions') : $viewModel->project->max_votes_per_user_for_solutions  }}">
                        </div>
                    </div>

                    <br>
                </div>
                <div class="row">
                    <label class="col-sm-12 control-label" for="name">Project Name (<span
                                class="red">*</span>)</label>
                    <div class="col-sm-12">
                        <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                            <input id="name" type="text" class="form-control" name="name"
                                   value="{{ old('name') ? old('name') : $viewModel->project->defaultTranslation->name  }}"
                                   required
                                   placeholder="Project Name">
                            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-12 control-label" for="description">Project Description (<span
                                class="red">*</span>)<br>
                    </label>
                    <div class="col-sm-12">
                        <div class="form-group has-feedback">
                                        <textarea id="description" class="form-control" name="description"
                                                  required
                                                  rows="6"
                                                  placeholder="Project Description">{{ old('description') ? old('description') : $viewModel->project->defaultTranslation->description }}</textarea>
                            <span class="help-block"><strong>{{ $errors->first('description') }}</strong></span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
