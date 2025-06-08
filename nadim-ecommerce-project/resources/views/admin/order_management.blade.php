<x-layout>
  <x-slot:title>
    <i class="fa fa-code-order fa-fw"></i> Order Management
  </x-slot:title>
  <div class="card">
    <div class="card-body pt-2">
      {{-- Table --}}
      <div class="table-responsive">
        <table id="orderTable" class="table table-stripped text-center table-bordered align-middle table-nowrap mb-0">
          <thead>
            <tr>
              <th class="text-center">Sr. No.</th>
              <th class="text-center">Branch</th>
              <th class="text-center">Order Date</th>
              <th class="text-center">Client Name</th>
              <th class="text-center">Client Number</th>
              <th class="text-center">Client Address</th>
              <th class="text-center">Client City</th>
              <th class="text-center">Client State</th>
              <th class="text-center">Product Code</th>
              <th class="text-center">Product Name</th>
              <th class="text-center">Price</th>
              <th class="text-center">Quantity</th>
              <th class="text-center">Coupon</th>
              <th class="text-center">Tax</th>
              <th class="text-center">Total Amount</th>
              <th class="text-center">Bill Download</th>
              <th class="text-center">Payment Status</th>
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
</x-layout>
<script>
  $(document).ready(function () {
    $('#orderTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("orders.data") }}',
        columns: [
          { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
          { data: 'branch', name: 'branch' },
          { data: 'created_at', name: 'created_at' },
          { data: 'client_name', name: 'client_name' },
          { data: 'client_number', name: 'client_number' },
          { data: 'client_address', name: 'client_address' },
          { data: 'client_city', name: 'client_city' },
          { data: 'client_state', name: 'client_state' },
          { data: 'product_code', name: 'product_code' },
          { data: 'product_name', name: 'product_name' },
          { data: 'price', name: 'price' },
          { data: 'qty', name: 'qty' },
          { data: 'coupon', name: 'coupon' },
          { data: 'tax', name: 'tax' },
          { data: 'total_amount', name: 'total_amount' },
          { data: 'bill_download', name: 'bill_download' },
          { data: 'status', name: 'status', orderable: false, searchable: false },
          { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
  });
</script>
