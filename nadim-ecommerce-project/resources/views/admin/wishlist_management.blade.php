<x-layout>
  <x-slot:title>
      <i class="fa fa-heart fa-fw"></i> Wishlist Management
  </x-slot:title>
    <div class="card">
      <div class="card-body pt-2">
        {{-- Table --}}
        <div class="table-responsive">
          <table id="wishlistTable" class="table table-stripped text-center table-bordered align-middle table-nowrap mb-0">
            <thead>
              <tr>
                <th class="text-center">Sr. No.</th>
                <th class="text-center">Wishlist Date</th>
                <th class="text-center">Client Name</th>
                <th class="text-center">Client Number</th>
                <th class="text-center">Client Address</th>
                <th class="text-center">Client City</th>
                <th class="text-center">Client State</th>
                <th class="text-center">Product Code</th>
                <th class="text-center">Product Name</th>
                <th class="text-center">Price</th>
                <th class="text-center">Quantity</th>
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
      $('#wishlistTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("wishlists.data") }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'formated_wishlist_date', name: 'formated_wishlist_date' },
            { data: 'client_name', name: 'name' },
            { data: 'client_number', name: 'number' },
            { data: 'client_address', name: 'address' },
            { data: 'client_city', name: 'city' },
            { data: 'client_state', name: 'state' },
            { data: 'product_code', name: 'product_code' },
            { data: 'product_name', name: 'product_name' },
            { data: 'price', name: 'price' },
            { data: 'qty', name: 'qty' },
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
