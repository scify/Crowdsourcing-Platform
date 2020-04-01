<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <input type="hidden" name="language_id" value="6">

                    <label class="col-sm-12 control-label" for="name">Project Name (<span
                                class="red">*</span>)</label>
                    <div class="col-sm-12">
                        <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                            <input id="name" type="text" class="form-control" name="name"
                                   value="{{ old('name') ? old('name') : $viewModel->project->name  }}"
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
                                                  placeholder="Project Description">{{ old('description') ? old('description') : $viewModel->project->description }}</textarea>
                            <span class="help-block"><strong>{{ $errors->first('description') }}</strong></span>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="status_id">Project status</label>
                            @if(!Gate::check('change-status-crowd-sourcing-projects'))
                                <small class="text-blue">(The project status can only be changed by a platform administrator.)</small>
                            @endif
                            <select id="status_id" class="form-control" name="status_id">
                                @foreach ($viewModel->projectStatusesLkp as $status)
                                    <option
                                            disabled="{{!Gate::allows('change-status-crowd-sourcing-projects')}}"
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
                        for example:
                        <i>http://crowdsourcing.scify.org/your-project-slug</i>)<br>
                        It can contain only letters, numbers, and dashes.<br>
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
                <div class="row image-input-container">
                    <label class="col-sm-12 control-label">Project Logo</label>
                    <div class="col-sm-12">
                        <div class="image-preview-container">
                            <img class="selected-image-preview"
                                 src="{{asset($viewModel->project->logo_path)}}"
                                 alt="Selected logo image">
                        </div>
                        <div class="form-group has-feedback input-file-wrapper">
                            <small>In order to update the currently selected image, please choose a new
                                image by
                                clicking the button below.
                            </small>
                            <input type="file" name="logo" class="image-input" accept="image/*">
                            <span class="help-block"><strong>{{ $errors->first('logo') }}</strong></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
