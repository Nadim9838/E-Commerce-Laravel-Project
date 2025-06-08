<h2>User List</h2>

@if (session('success'))
    <div>{{ session('success') }}</div>
@endif

<table class="table text-center">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Roles</th>
            <th>Permissions</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->getRoleNames()->join(', ') }}</td>
                <td>{{ $user->getPermissionNames()->join(', ') }}</td>
                <td>
                    <a href="{{ route('users.edit', $user->id) }}">Edit</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
