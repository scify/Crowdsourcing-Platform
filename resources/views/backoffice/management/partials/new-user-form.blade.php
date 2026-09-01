<form action="{{ url('backoffice/add-user') }}" method="POST">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-6">
            <div class="col-md-12 mb-3">
                <div class="mb-3 ">
                    <label for="email" class="visually-hidden form-label">Email</label>
                    <input id="email" type="email" class="form-control" name="email" required autofocus
                           placeholder="Email">
                </div>

                <div class="mb-3 ">
                    <label for="name" class="visually-hidden form-label">Full name</label>
                    <input id="name" type="text" class="form-control" name="nickname" required autofocus
                           placeholder="Full name">
                </div>
                <div class="mb-3">
                    <label for="password" class="visually-hidden form-label">Password</label>
                    <input id="password" type="password" class="form-control" name="password" required autofocus
                           placeholder="Password">
                </div>
                <div class="mb-3">
                    <label for="roleselect" class="visually-hidden form-label">Select a role</label>
                    <select class="form-control" name="roleselect" id="roleselect">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" name="roleVal[{{ $role->id }}]">
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="gender" class="visually-hidden form-label">{{ __("login-register.gender") }}</label>
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
                <div class="mb-3">
                    <label for="country" class="visually-hidden form-label">{{ __("login-register.country") }}</label>
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
                <div class="mb-3">
                    <label for="year-of-birth" class="visually-hidden form-label">{{ __("login-register.year_of_birth") }}</label>
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


                <div class="col-md-3 p-0 mb-3">
                    <button type="submit" class="btn btn-primary btn-block btn-slim">Add user</button>
                </div>
            </div>
        </div>
    </div>
</form>
