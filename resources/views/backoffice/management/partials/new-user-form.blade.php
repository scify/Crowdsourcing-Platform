<form action="{{ url('backoffice/add-user') }}" method="POST">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-6">
            <div class="col-md-12 form-group">
                <div class="form-group ">
                    <label for="email" class="sr-only">Email</label>
                    <input id="email" type="email" class="form-control" name="email" required autofocus
                           placeholder="Email">
                </div>

                <div class="form-group ">
                    <label for="name" class="sr-only">Full name</label>
                    <input id="name" type="text" class="form-control" name="nickname" required autofocus
                           placeholder="Full name">
                </div>
                <div class="form-group">
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" type="password" class="form-control" name="password" required autofocus
                           placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="roleselect" class="sr-only">Select a role</label>
                    <select class="form-control" name="roleselect" id="roleselect">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" name="roleVal[{{ $role->id }}]">
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="gender" class="sr-only">{{ __("login-register.gender") }}</label>
                    <select class="form-control" name="gender" id="gender">
                        <option value="">{{ __("login-register.gender") }}</option>
                        @foreach ($viewModel->availableGenders as $gender)
                            <option
                                    @if (old('gender') == $gender->value)
                                        selected
                                    @endif
                                    value="{{ $gender->value }}"
                            >
                                {{ __('common.' . $gender->value) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="country" class="sr-only">{{ __("login-register.country") }}</label>
                    <select class="form-control" name="country" id="country">
                        <option value="">{{ __("login-register.country") }}</option>
                        @foreach ($viewModel->availableCountries as $country)
                            <option
                                    @if (old('country') == $country->name)
                                        selected
                                    @endif
                                    value="{{ $country->name }}"
                            >
                                {{ $country->value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="year-of-birth" class="sr-only">{{ __("login-register.year_of_birth") }}</label>
                    <select class="form-control" name="year-of-birth" id="year-of-birth">
                        <option value="">{{ __("login-register.year_of_birth") }}</option>
                        @foreach ($viewModel->availableYearsOfBirth as $year)
                            <option
                                    @if (old('year-of-birth') == $year)
                                        selected
                                    @endif
                                    value="{{ $year }}"
                            >
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-12 margin-top">


                <div class="col-md-3 p-0 form-group">
                    <button type="submit" class="btn btn-primary btn-block btn-slim">Add user</button>
                </div>
            </div>
        </div>
    </div>
</form>
