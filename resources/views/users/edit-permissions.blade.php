<h2>Edit Roles & Permissions for {{ $user->name }}</h2>

<form method="POST" action="{{ route('users.update', $user->id) }}">
    @csrf
    @method('PUT')

    <h4>Roles</h4>
    @foreach($roles as $role)
        <div>
            <label>
                <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                    {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                {{ $role->name }}
            </label>
        </div>
    @endforeach

    <h4>Permissions</h4>
    @foreach($permissions as $permission)
        <div>
            <label>
                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                    {{ $user->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                {{ $permission->name }}
            </label>
        </div>
    @endforeach

    <button type="submit">Save</button>
</form>
