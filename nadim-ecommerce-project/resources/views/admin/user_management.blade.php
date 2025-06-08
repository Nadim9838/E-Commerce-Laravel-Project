<x-layout>
    <x-slot:title>
      <i class="fa fa-users fa-fw"></i> User Management
    </x-slot:title>
    <button class="btn btn-primary text-right mb-2" id="addUserBtn" title="Add New User"><i class="mdi mdi-plus me-1"></i> Add User</button>
    <div class="card">
      <div class="card-body">
        
        {{-- Add & Update Modal --}}
        <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="UserModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <form id="userForm" method="post" enctype="multipart/form-data">
                @csrf
                  <div class="modal-content">
                      <div class="modal-header">
                          <i class="fa fa-user fa-fw"></i>&nbsp;
                          <h5 class="modal-title">User Form</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body  p-4">
                          <input type="hidden" id="userId">

                          <div class="mb-2"><label>Name</label><span class="text-danger">*</span>
                            <input type="text" name="name" class="form-control" id="name" required>
                          </div>

                          <div class="mb-2"><label>Email</label><span class="text-danger">*</span>
                            <input type="email" name="email" class="form-control" id="email" required>
                          </div>

                          <div class="mb-2"><label>Mobile</label><span class="text-danger">*</span>
                            <input type="number" min="0" name="mobile" class="form-control mobile_validation" id="mobile" required>
                          </div>

                          <div class="mb-2"><label>User Image</label>
                            <input type="file" name="user_image" class="form-control" id="user_image" accept=".png,.jpg,.jpeg">

                            <img id="user_image_preview" class="img-thumbnail mt-2" src="" style="max-width: 150px;">
                          </div>

                          <div class="mb-2"><label>Branch Code</label>
                            <input type="text" name="branch_code" class="form-control" id="branch_code">
                          </div>

                          <div class="mb-2"><label>Branch Name</label>
                            <input type="text" name="branch_name" class="form-control" id="branch_name">
                          </div>

                          <div class="mb-2"><label>Password</label><span class="text-danger">*</span>
                            <input type="password" name="password" class="form-control" id="password" required>
                          </div>
                          
                          <div class="mb-2"><label>Confirm Password</label><span class="text-danger">*</span>
                            <input type="password" class="form-control" id="password_confirmation" required>
                          </div>

                          <div class="mb-2"><label>User Role</label><span class="text-danger">*</span>
                            <select name="role" id="role" class="form-control form-select" required>
                              <option value="">Select User Role</option>
                              <option value="Admin">Admin</option>
                              <option value="Sub-Admin">Sub-Admin</option>
                              <option value="User">User</option>
                            </select>
                          </div>

                          <div class="mb-2"  id="statusField" style="display: none;">
                            <label>Status</label>
                            <select name="status" id="user_status" class="form-control form-select">
                              <option value="">Select User Status</option>
                              <option value="1">Active</option>
                              <option value="0">Inactive</option>
                            </select>
                          </div>
                      </div>
                      
                      <div class="modal-footer">
                          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-xmark"></i> Close</button>
                      </div>
                  </div>
              </form>
          </div>
        </div>
        {{-- End Add & Update Modal --}}

        {{-- Table --}}
        <div class="table-responsive">
          <table id="dataTable" class="table text-center align-middle table-nowrap mb-0">
            <thead>
              <tr>
                <th class="text-center">Sr. No.</th>
                <th class="text-center">Image</th>
                <th class="text-center">Name</th>
                <th class="text-center">User Code</th>
                <th class="text-center">Email</th>
                <th class="text-center">Mobile</th>
                <th class="text-center">Branch Name</th>
                <th class="text-center">Branch Code</th>
                <th class="text-center">Permissions</th>
                <th class="text-center">Role</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($users as $index => $user)
              <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>
                  @if ($user->user_image)
                  <img src="{{ asset('storage/' . $user->user_image) }}" class="avatar-sm rounded-circle"> 
                  @else
                    <div class="avatar-xs d-inline-block me-2">
                      <div class="avatar-title bg-primary rounded-circle">
                          <i class="mdi mdi-account-circle"></i>
                      </div>
                    </div>
                  @endif
                </td>
                <td>
                  {{ $user->name }}
                </td>
                <td>{{ $user->user_code }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->mobile }}</td>
                <td>{{ $user->branch_name }}</td>
                <td>{{ $user->branch_code }}</td>
                <td>
                  <a href="{{ route('get_user_permission', $user->id) }}" class="btn btn-sm btn-primary" title="Add User Permissions"><i class="fa-solid fa-user-lock"></i> Add Permission</a>
                </td>
                <td>{{ $user->role }}</td>
                <td>
                  @if ($user->status === 1)
                    <span class="badge rounded badge-soft-success font-size-12">Active</span>
                    @else
                    <span class="badge rounded badge-soft-danger font-size-12">Inactive</span>
                  @endif
                </td>
                <td>
                  <div class="d-flex gap-3 justify-content-center">
                      <a href="#" class="btn btn-success btn-sm user-btn-edit" title="Edit User" data-user='@json($user)'><i class="mdi mdi-pencil"></i></a>

                      <form class="delete-confirmation" action="{{ route('delete_user', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm btn-delete" title="Delete User"><i class="mdi mdi-delete"></i></button>
                      </form>
                  </div>
                </td>
              </tr>
              @empty
              @endforelse
            </tbody>
          </table>
          {{-- End Table --}}
        </div>
      </div>
    </div>
  </div>
</x-layout>