<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row image-input-container">
                    <label for="sm_featured_img" class="col-sm-12 control-label">Featured Image </label>
                    <div class="col-sm-12">
                        <div class="image-preview-container">
                            <img loading="lazy" class="selected-image-preview"
                                 src="{{$viewModel->project->sm_featured_img_path ? asset($viewModel->project->sm_featured_img_path) : ''}}"
                                 alt="Social media featured">
                        </div>
                        <div class="form-group has-feedback input-file-wrapper">
                            <small>In order to update the currently selected image, please choose a new
                                image by
                                clicking the button below.
                            </small>
                            <input id="sm_featured_img" type="file" name="sm_featured_img" class="image-input"
                                   accept="image/*">
                            <span class="help-block"><strong>{{ $errors->first('sm_featured_img') }}</strong></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-12 control-label" for="sm_title">Social Media Title</label>
                    <div class="col-sm-12">
                        <div class="form-group has-feedback {{ $errors->has('sm_title') ? 'has-error' : '' }}">
                            <input id="sm_title" type="text" class="form-control" name="sm_title"
                                   value="{{ old('sm_title') ? old('sm_title') : $viewModel->project->defaultTranslation->sm_title  }}"
                                   placeholder="Enter the title you would like to appear when posting the project to social media">
                            <span class="help-block"><strong>{{ $errors->first('sm_title') }}</strong></span>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <label class="col-md-12 control-label" for="sm_description">Social Media Description<br>
                    </label>
                    <div class="col-md-12">
                        <div class="form-group has-feedback">
                        <textarea id="sm_description" class="form-control" name="sm_description"
                                  placeholder="Enter the description you would like to appear when posting the project to social media">
                            {{ old('sm_description') ? old('sm_description') : trim($viewModel->project->defaultTranslation->sm_description) }}</textarea>
                            <span class="help-block"><strong>{{ $errors->first('sm_description') }}</strong></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-12 control-label" for="sm_keywords">Social Media Keywords<br>
                    </label>
                    <p class="col-md-12">Type enter or comma in order to separate the keywords.</p>
                    <div class="col-md-12">
                        <select name="sm_keywords[]" id="sm_keywords" class="form-control w-100" multiple="multiple">
                            @foreach($viewModel->project->defaultTranslation->sm_keywords ? explode(',', $viewModel->project->defaultTranslation->sm_keywords) : [] as $index => $keyword)
                                <option selected="selected">{{ $keyword }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
