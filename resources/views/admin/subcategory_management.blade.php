<x-layout>
  <x-slot:title>
    <i class="fa fa-tags fa-fw"></i> Sub Category Management
  </x-slot:title>
  <button class="btn btn-primary text-right mb-2" id="addSubCategoryBtn" title="Add New Sub Category"><i class="mdi mdi-plus me-1"></i> Add Sub Category</button>
  <div class="card">
    <div class="card-body pt-2">

      {{-- Add & Update Modal --}}
      <div class="modal fade" id="subCategoryModal" tabindex="-1" aria-labelledby="SubCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="subCategoryForm" method="post" enctype="multipart/form-data">
              @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <i class="fa fa-tags fa-fw"></i>&nbsp;
                        <h5 class="modal-title">Sub Category Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="subCategoryId">

                        <div class="mb-2">
                          <label>Main Category</label><span class="text-danger">*</span>
                          <select name="category_id" id="category_id" class="form-control form-select selectpicker" data-live-search="true" title="Select Main Category">
                            @foreach($mainCategories as $category)
                              <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                          </select>
                        </div>

                        <div class="mb-2"><label>Sub Category Name</label><span class="text-danger">*</span>
                          <input type="text" name="subcategory_name" class="form-control" id="subcategory_name" required>
                        </div>

                        <div class="mb-2"><label>Sub Category Image</label>
                          <input type="file" name="subcategory_image" class="form-control" id="subcategory_image" accept=".png,.jpg,.jpeg,.ico, .gif">

                          <img id="subcategory_image_preview" class="img-thumbnail mt-2" src="" style="max-width: 100px;">
                        </div>

                        <div class="mb-2"><label>Meta Title</label>
                          <textarea name="meta_title" class="form-control" id="meta_title" rows="2"></textarea>
                        </div>
                        
                        <div class="mb-2"><label>Meta Tags</label>
                          <textarea name="meta_tags" class="form-control" id="meta_tags" rows="2"></textarea>
                        </div>

                        <div class="mb-2"><label>Meta Keywords</label>
                          <textarea name="meta_keywords" class="form-control" id="meta_keywords" rows="3"></textarea>
                        </div>

                        <div class="mb-2"  id="statusField" style="display: none;">
                          <label>Status</label>
                          <select name="status" id="subcategory_status" class="form-control form-select">
                            <option value="">Select Sub Category Status</option>
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
        <table id="subCategoryTable" class="table table-stripped text-center table-bordered align-middle table-nowrap mb-0">
          <thead>
            <tr>
              <th class="text-center">Sr. No.</th>
              <th class="text-center">Sub Category Image</th>
              <th class="text-center">Sub Main Category</th>
              <th class="text-center">Sub Category Code</th>
              <th class="text-center">Sub Category Name</th>
              <th class="text-center">Meta Title</th>
              <th class="text-center">Meta Tags</th>
              <th class="text-center">Meta Keywords</th>
              <th class="text-center">Slug</th>
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
      $('#subCategoryTable').DataTable({
          processing: true,
          serverSide: true,
          ajax: '{{ route("subcategory.data") }}',
          columns: [
              { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
              { data: 'subcategory_image', name: 'subcategory_image', orderable: false, searchable: false },
              { data: 'category_name', name: 'category.category_name' },
              { data: 'subcategory_code', name: 'subcategory_code' },
              { data: 'subcategory_name', name: 'subcategory_name' },
              { data: 'meta_title', name: 'meta_title' },
              { data: 'meta_tags', name: 'meta_tags' },
              { data: 'meta_keywords', name: 'meta_keywords' },
              { data: 'slug', name: 'slug' },
              { data: 'total_products', name: 'total_products' },
              { data: 'status', name: 'status', orderable: false, searchable: false },
              { data: 'action', name: 'action', orderable: false, searchable: false }
          ],
      dom: 'Blfrtip',
      buttons: [
          'csv', 'excel', 'pdf'
      ],
      lengthMenu: [[10, 25, 50, 100, 200, 500, -1], [10, 25, 50, 100, 200, 500, "All"]]
    });
  });
</script>
