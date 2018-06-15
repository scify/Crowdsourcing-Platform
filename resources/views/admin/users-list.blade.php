<div id="mentorsList">
<table id="userListTable" class="table table-hover">
    <tbody>
    <tr>
        <th>
            Name
        </th>
        <th>
            Surname
        </th>
        <th>
            Email
        </th>
        <th>
            Roles
        </th>
        <th>
            Action
        </th>
    </tr>
    @foreach ($users as $user)
        <tr>
            <td>
                {{ $user->name }}
            </td>
            <td>
                {{ $user->surname }}
            </td>
            <td>
                {{ $user->email }}
            </td>
            <td>
                @foreach($user->roles as $role)
                    {{ $role->name }}@if(!$loop->last), @endif
                @endforeach
            </td>
            <td>
                <div class="row">
                    <div class="col-sm-6">
                        <form action="{{ url('admin/edit-user') . '/' . $user->id }}" method="GET">
                            <button type="submit" class="btn btn-block btn-primary">Edit user</button>
                        </form>
                    </div>
                    <div class="col-sm-6">
                        @if ($user->id != Auth::id())
                            @if(!$user->trashed())
                                <form class="form-disable" action="{{ url('user/delete') }}" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                    <button type="submit" class="btn btn-block btn-danger">Deactivate user</button>
                                </form>
                            @else
                                <form class="form-disable" action="{{ url('user/restore') }}" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                    <button type="submit" class="btn btn-block btn-success">Reactivate user</button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
    {{ method_exists($users, 'links') ? $users->links() : '' }}
</div>