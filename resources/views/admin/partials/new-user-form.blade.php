<form action="{{ url('admin/add-user') }}" method="POST">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-6">

            <div class="col-md-12 form-group">
                <em>Insert email and choose role. If the email exists in database, the role will be added to the user.</em>
                <br>
                <br>
                <input id="email" type="email" class="form-control" name="email" required autofocus
                       placeholder="Email">
            </div>
            <div class="col-md-12">
                <div class="col-md-6 no-padding form-group">

                    <select class="form-control" name="roleselect">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" name="roleVal[{{ $role->id }}]">
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>

                </div>
            </div>
            <div class="col-md-12 margin-top">
                <em>
                    Data for new user (if the email does not exist in the database, a new user will be created):
                </em>
                <div class="form-group margin-top">
                    <input id="name" type="text" class="form-control" name="nickname" required autofocus
                           placeholder="Full name">
                </div>
                <div class="form-group">
                    <input id="password" type="password" class="form-control" name="password" required autofocus
                           placeholder="Password">
                </div>

                <div class="col-md-3 no-padding form-group">
                    <button type="submit" class="btn btn-primary btn-block ">Add user</button>
                </div>
            </div>
        </div>
    </div>
</form>