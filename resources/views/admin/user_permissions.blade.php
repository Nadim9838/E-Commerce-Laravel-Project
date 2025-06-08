<x-layout>
    <x-slot:title>
      <i class="fa-solid fa-user-lock"></i> User Permissions
    </x-slot:title>
    <div class="container mt-4">
        <a href="{{ route('user-management') }}" class="btn btn-outline-secondary btn-sm back_button"><i class="fa-solid fa-arrow-left me-1"></i> Back</a>
        <h4 class="mb-4">Assign Permissions for {{ $user->name }}</h4>

    <form method="POST" action="{{ route('save_user_permission', $user->id) }}">
        @csrf

        <div class="mb-3 text-end">
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="toggleAll(true)">Check All</button>
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="toggleAll(false)">Uncheck All</button>
        </div>

        <div class="row">
            @foreach($modules as $module)
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <strong>{{ $module['name'] }}</strong>
                            <button type="button" class="btn btn-sm btn-link" onclick="toggleCard('{{ $module['key'] }}', true)">Check All</button>
                        </div>
                        <div class="card-body">
                            @foreach(['view', 'add', 'edit', 'delete', 'export'] as $action)
                                <div class="form-check">
                                    <input class="form-check-input permission-checkbox {{ $module['key'] }}" 
                                           type="checkbox" 
                                           name="permissions[{{ $module['key'] }}][]" 
                                           value="{{ $action }}"
                                           {{ in_array($action, $userPermissions[$module['key']] ?? []) ? 'checked' : '' }}>
                                    <label class="form-check-label text-capitalize">
                                        {{ $action }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary mb-4"><i class="fa fa-plus"></i> Save Permissions</button>
        </div>
    </form>
</div>

<script>
    function toggleAll(state) {
        document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = state);
    }

    function toggleCard(moduleKey, state) {
        document.querySelectorAll('.' + moduleKey).forEach(cb => cb.checked = state);
    }
</script>
</x-layout>
