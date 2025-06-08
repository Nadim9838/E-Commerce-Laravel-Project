<x-layout>
  <x-slot:title>
      <i class="fa fa-handshake fa-fw"></i> Client Management
  </x-slot:title>
  {{-- <button class="btn btn-primary text-right mb-2" id="addClientBtn">Add Client</button> --}}
    <div class="card">
      <div class="card-body pt-2">
        {{-- Client Addresses Modal --}}
        <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <i class="fa-solid fa-location-dot"></i>&nbsp;
                <h5 class="modal-title" id="addressModalLabel">Addresses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Sr. No.</th>
                      <th>Address</th>
                      <th>City</th>
                      <th>State</th>
                      <th>Country</th>
                      <th>Zip Code</th>
                      <th>Address Type</th>
                    </tr>
                  </thead>
                  <tbody id="addressTableBody">
                    <!-- Filled dynamically -->
                  </tbody>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-xmark"></i> Close</button>
              </div>
            </div>
          </div>
        </div>

        {{-- Add & Update Modal --}}
        <div class="modal fade" id="clientModal" tabindex="-1" aria-labelledby="ClientModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <form id="clientForm" method="post" novalidate>
                @csrf
                  <div class="modal-content">
                      <div class="modal-header">
                          <i class="fa fa-handshake fa-fw"></i>&nbsp;
                          <h5 class="modal-title">Client Form</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                          <input type="hidden" id="clientId">

                          <div class="mb-2"><label>Client Name</label><span class="text-danger">*</span>
                            <input type="text" name="name" class="form-control disabled" disabled id="client_name" required>
                          </div>

                          <div class="mb-2"><label>Client Email</label><span class="text-danger">*</span>
                            <input type="email" name="email" class="form-control disabled" disabled id="client_email" required>
                          </div>

                          <div class="mb-2"><label>Client Number</label><span class="text-danger">*</span>
                            <input type="number" min="0" name="mobile" class="form-control disabled mobile_validation" disabled id="client_number" required>
                          </div>

                          <div class="mb-2"  id="statusField" style="display: none;">
                            <label>Status</label>
                            <select name="status" id="client_status" class="form-control form-select">
                              <option value="">Select Client Status</option>
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
          <table id="clientTable" class="table table-stripped text-center table-bordered align-middle table-nowrap mb-0">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Number</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Last Order</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
          </table>
          {{-- End Table --}}
        </div>
      </div>
    </div>
  </div>
</x-layout>
<script>
  $(document).ready(function() {
    $('#clientTable').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('clients.data') }}",
      columns: [
          { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
          { data: 'name', name: 'name' },
          { data: 'email', name: 'email' },
          { data: 'mobile', name: 'mobile' },
          { data: 'dob', name: 'dob' },
          { data: 'gender', name: 'gender' },
          { data: 'address', name: 'address', orderable: false, searchable: false },
          { data: 'last_order', name: 'last_order' },
          { data: 'status', name: 'status' },
          { data: 'actions', name: 'actions', orderable: false, searchable: false }
      ],
      dom: 'Blfrtip',
      buttons: [
          'csv', 'excel', 'pdf'
      ],
      lengthMenu: [[10, 25, 50, 100, 200, 500, -1], [10, 25, 50, 100, 200, 500, "All"]]
    });
  });

  $(document).on('click', '.view-address-btn', function () {
    const clientId = $(this).data('id');
    $.ajax({
        url: `/clients/${clientId}/addresses`,
        method: 'GET',
        success: function (data) {
            $('#addressModalLabel').text(`Addresses of ${data.client_name}`);
            let addresses = Array.isArray(data.addresses) ? data.addresses : [data.addresses];
            let rows = '';
            addresses.forEach((address, index) => {
                rows += `<tr>
                    <td>${index + 1}</td>
                    <td>${address.address ?? '-'}</td>
                    <td>${address.city ?? '-'}</td>
                    <td>${address.state ?? '-'}</td>
                    <td>${address.country ?? '-'}</td>
                    <td>${address.zip_code ?? '-'}</td>
                    <td>${address.address_type ?? '-'}</td>
                </tr>`;
            });

            $('#addressTableBody').html(rows);
            $('#addressModal').modal('show');
        }
    });
});
</script>