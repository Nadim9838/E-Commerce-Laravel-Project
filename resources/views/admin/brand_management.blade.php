<x-layout>
  <x-slot:title>
    <i class="fa fa-building fa-fw"></i> Brand Management
  </x-slot:title>
  <button class="btn btn-primary text-right mb-2" id="addBrandBtn"><i class="mdi mdi-plus me-1"></i> Add Brand</button>
  <div class="card">
    <div class="card-body pt-2">
      
      {{-- Add & Update Modal --}}
      <div class="modal fade" id="brandModal" tabindex="-1" aria-labelledby="BrandModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="brandForm" method="post" enctype="multipart/form-data">
              @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <i class="fa fa-building fa-fw"></i>&nbsp;
                        <h5 class="modal-title">Brand Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="brandId">

                        <div class="mb-2"><label>Brand Name</label><span class="text-danger">*</span>
                          <input type="text" name="brand_name" class="form-control" id="brand_name" required>
                        </div>

                        <div class="mb-2"><label>Brand Image</label>
                          <input type="file" name="brand_image" class="form-control" id="brand_image" accept=".png,.jpg,.jpeg,.ico, .gif">

                          <img id="brand_image_preview" class="img-thumbnail mt-2" src="" style="max-width: 100px;">
                        </div>

                        <div class="mb-2"><label>Meta Title</label>
                          <textarea name="meta_title" class="form-control" id="meta_title" rows="4"></textarea>
                        </div>
                        
                        <div class="mb-2"><label>Meta Tags</label>
                          <textarea name="meta_tags" class="form-control" id="meta_tags" rows="4"></textarea>
                        </div>

                        <div class="mb-2"><label>Meta Keywords</label>
                          <textarea name="meta_keywords" class="form-control" id="meta_keywords" rows="4"></textarea>
                        </div>

                        <div class="mb-2"  id="statusField" style="display: none;">
                          <label>Status</label>
                          <select name="status" id="brand_status" class="form-control form-select">
                            <option value="">Select Brand Status</option>
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
        <table id="brandTable" class="table table-stripped text-center table-bordered align-middle table-nowrap mb-0">
          <thead>
            <tr>
              <th class="text-center">Sr. No.</th>
              <th class="text-center">Brand Image</th>
              <th class="text-center">Brand Code</th>
              <th class="text-center">Brand Name</th>
              <th class="text-center">Meta Title</th>
              <th class="text-center">Meta Tags</th>
              <th class="text-center">Meta Keywords</th>
              <th class="text-center">Total Products</th>
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
</x-layout>
<script>
$(document).ready(function () {
    $('#brandTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("brands.data") }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'brand_image', name: 'brand_image', orderable: false, searchable: false },
            { data: 'brand_code', name: 'brand_code' },
            { data: 'brand_name', name: 'brand_name' },
            { data: 'meta_title', name: 'meta_title' },
            { data: 'meta_tags', name: 'meta_tags' },
            { data: 'meta_keywords', name: 'meta_keywords' },
            { data: 'total_products', name: 'total_products' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
