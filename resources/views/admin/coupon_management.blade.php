<x-layout>
  <x-slot:title>
      <i class="fa fa-ticket-alt fa-fw"></i> Coupon Management
  </x-slot:title>
  <button class="btn btn-primary text-right mb-2" id="addCouponBtn" title="Add New Coupon"><i class="mdi mdi-plus me-1"></i> Add Coupon</button>
    <div class="card">
      <div class="card-body pt-2">
        
        {{-- Add & Update Modal --}}
        <div class="modal fade" id="couponModal" tabindex="-1" aria-labelledby="CouponModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <form id="couponForm" method="post" novalidate>
                @csrf
                  <div class="modal-content">
                      <div class="modal-header">
                          <i class="fa fa-ticket-alt fa-fw"></i>&nbsp;
                          <h5 class="modal-title">Coupon Form</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">
                          <input type="hidden" id="couponId">

                          <div class="mb-2"><label>Coupon Code</label><span class="text-danger">*</span>
                            <input type="text" name="coupon_code" class="form-control" id="coupon_code" required>
                          </div>

                          <div class="mb-2"><label>Coupon Name</label><span class="text-danger">*</span>
                            <input type="text" name="coupon_name" class="form-control" id="coupon_name" required>
                          </div>

                          <div class="mb-2"><label>Offer(in %)</label><span class="text-danger">*</span>
                            <input type="number" step="0.00" min="0" name="offer" class="form-control" id="offer" required>
                          </div>

                          <div class="mb-2"><label>Validity</label><span class="text-danger">*</span>
                            <input type="date" name="validity" class="form-control date" id="validity" required>
                          </div>

                          <div class="mb-2"><label>Terms & Conditions</label>
                            <textarea name="terms_condition" id="terms_condition" rows="3" class="form-control"></textarea>
                          </div>                          

                          <div class="mb-2"><label>No. of Time</label><span class="text-danger">*</span>
                            <input type="number" min="0" name="no_of_time" class="form-control mobile_validation" id="no_of_time" required>
                          </div>

                          <div class="mb-2"  id="statusField" style="display: none;">
                            <label>Status</label>
                            <select name="status" id="coupon_status" class="form-control form-select">
                              <option value="">Select Coupon Status</option>
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
          <table id="couponTable" class="table table-stripped text-center table-bordered align-middle table-nowrap mb-0">
            <thead>
              <tr>
                <th class="text-center">Sr. No.</th>
                <th class="text-center">Date of Creation</th>
                <th class="text-center">Coupon Code</th>
                <th class="text-center">Coupon Name</th>
                <th class="text-center">Offer</th>
                <th class="text-center">Terms & Conditions</th>
                <th class="text-center">Validity</th>
                <th class="text-center">No. of Time</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
          {{-- End Table --}}
        </div>
      </div>
    </div>
  </div>
</x-layout>
<script>
$(document).ready(function () {
    $('#couponTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("coupons.data") }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'created_at', name: 'created_at' },
            { data: 'coupon_code', name: 'coupon_code' },
            { data: 'coupon_name', name: 'coupon_name' },
            { data: 'offer', name: 'offer' },
            { data: 'terms_condition', name: 'terms_condition' },
            { data: 'validity', name: 'validity' },
            { data: 'no_of_time', name: 'no_of_time' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
      dom: 'Blfrtip',
      buttons: [
          'csv', 'excel', 'pdf'
      ],
      lengthMenu: [[10, 25, 50, 100, 200, 500, -1], [10, 25, 50, 100, 200, 500, "All"]]
    });
});
</script>
