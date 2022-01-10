<div id="usersList">
    <table id="userListTable" class="table table-hover" cellspacing="0" style="width: 100%;">
        <thead>
        <tr>
            <th>
                Nickname
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
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>

                    {{ $user->nickname }}
                    @if ($user->avatar)
                        <img loading="lazy" src="{{$user->avatar}}"/>
                    @endif
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
