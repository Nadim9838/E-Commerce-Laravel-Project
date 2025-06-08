<x-layout>
  <x-slot:title>
    <i class="fa fa-code-branch fa-fw"></i> Branch Management
  </x-slot:title>
  <button class="btn btn-primary text-right mb-2" id="addBranchBtn" title="Add New Branch"><i class="mdi mdi-plus me-1"></i> Add Branch</button>
  <div class="card">
    <div class="card-body pt-2">
      
      {{-- Add & Update Modal --}}
      <div class="modal fade" id="branchModal" tabindex="-1" aria-labelledby="BranchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="branchForm" method="post" enctype="multipart/form-data" novalidate>
              @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <i class="fa fa-code-branch fa-fw"></i>
                        <h5 class="modal-title">Branch Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="branchId">

                        <div class="mb-2"><label>Branch Code</label><span class="text-danger">*</span>
                          <input type="text" name="branch_code" class="form-control" id="branch_code" required>
                        </div>

                        <div class="mb-2"><label>Branch Name</label><span class="text-danger">*</span>
                          <input type="text" name="name" class="form-control" id="branch_name" required>
                        </div>
                        
                        <div class="mb-2"><label>Mobile</label><span class="text-danger">*</span>
                          <input type="number" min="0" name="number" class="form-control mobile_validation" id="branch_mobile" required>
                        </div>

                        <div class="mb-2"><label>Email</label><span class="text-danger">*</span>
                          <input type="email" name="email" class="form-control" id="branch_email" required>
                        </div>

                        <div class="mb-2"><label>Branch Login Id</label>
                          <input type="text" name="login_id" class="form-control" id="login_id">
                        </div>

                        <div class="mb-2"><label>Branch Password</label><span class="text-danger">*</span>
                          <input type="password" name="password" class="form-control" id="branch_password" required>
                        </div>

                        <div class="mb-2"><label>Branch Logo</label>
                          <input type="file" name="branch_logo" class="form-control" id="branch_logo" accept=".png,.jpg,.jpeg,.ico">

                          <img id="branch_logo_preview" class="img-thumbnail mt-2" src="" style="max-width: 100px;">
                        </div>

                        <div class="mb-2"><label>Branch Address</label>
                          <textarea name="address" class="form-control" id="branch_address" rows="4"></textarea>
                        </div>

                        <div class="mb-2"><label>GST No.</label>
                          <input type="text" name="gst_no" maxlength="15" class="form-control" id="branch_gst_no">
                          <small id="gstError" class="text-danger d-none">Invalid GST number format.</small>
                        </div>
                        
                        <div class="mb-2"><label>Support Mobile</label>
                          <input type="text" name="support_number" class="form-control mobile_validation" id="branch_support_number">
                        </div>
                        
                        <div class="mb-2"><label>Support Email</label>
                          <input type="email" name="support_email" class="form-control" id="branch_support_email">
                        </div>

                        <div class="mb-2"  id="statusField" style="display: none;">
                          <label>Status</label>
                          <select name="status" id="branch_status" class="form-control form-select">
                            <option value="">Select Branch Status</option>
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
        <table id="dataTable" class="table table-stripped text-center table-bordered align-middle table-nowrap mb-0">
          <thead>
            <tr>
              <th class="text-center">Sr. No.</th>
              <th class="text-center">Branch Logo</th>
              <th class="text-center">Branch Code</th>
              <th class="text-center">Branch Name</th>
              <th class="text-center">Branch Mobile</th>
              <th class="text-center">Branch Email</th>
              <th class="text-center">Login ID</th>
              <th class="text-center">Branch Address</th>
              <th class="text-center">GST No.</th>
              <th class="text-center">Support Number</th>
              <th class="text-center">Support Email</th>
              <th class="text-center">Status</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($branches as $index => $branch)
            <tr>
              <td class="text-center">{{ $index + 1 }}</td>
              <td>
                @if ($branch->branch_logo)
                <img src="{{ $branch->branch_logo }}" class="avatar-sm rounded-circle">
                @endif
              </td>
              <td>{{ $branch->branch_code }}</td>
              <td>{{ $branch->name }}</td>
              <td>{{ $branch->number }}</td>
              <td>{{ $branch->email }}</td>
              <td>{{ $branch->login_id }}</td>
              <td>{{ $branch->address }}</td>
              <td>{{ $branch->gst_no }}</td>
              <td>{{ $branch->support_number }}</td>
              <td>{{ $branch->support_email }}</td>
              <td>
                @if ($branch->status === 1)
                  <span class="badge rounded badge-soft-success font-size-12">Active</span>
                  @else
                  <span class="badge rounded badge-soft-danger font-size-12">Inactive</span>
                @endif
              </td>
              <td>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="#" class="btn btn-success btn-sm branch-btn-edit" title="Edit Branch" data-branch='@json($branch)'><i class="mdi mdi-pencil"></i></a>

                    <form class="delete-confirmation" action="{{ route('delete_branch', $branch->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" title="Delete Branch"><i class="mdi mdi-delete"></i></button>
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
</x-layout>