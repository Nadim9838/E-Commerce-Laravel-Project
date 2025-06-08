<x-layout>
  <x-slot:title>
    <i class="fa fa-clipboard fa-fw"></i> Product & Inventory Management
  </x-slot:title>
  <button class="btn btn-primary text-right mb-2" id="addProductBtn" title="Add New Product"><i class="mdi mdi-plus me-1"></i> Add Product</button>
  <div class="card">
    <div class="card-body pt-2">
      
      <!-- Photos Modal -->
      <div class="modal fade" id="photosModal" tabindex="-1" role="dialog" aria-labelledby="photosModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="photosModalLabel">Product Photos</h5>
                      <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body" id="photosModalBody">
                      <!-- Photos will be loaded here via AJAX -->
                      <div class="d-flex flex-wrap gap-3" id="productPhotosContainer"></div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
              </div>
          </div>
      </div>

      <!-- Product Attributes Modal -->
      <div class="modal fade" id="productAttributesModal" tabindex="-1" aria-labelledby="productAttributesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Product Attributes</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

              <form id="addAttributeForm">
                <input type="hidden" id="product_id">
                <input type="hidden" id="csrf_token" value="{{ csrf_token() }}">

                <div class="row g-2 mb-3">
                  <!-- Attribute Type Dropdown -->
                  <div class="col-md-5">
                    <select name="key" class="form-control form-select" id="attribute_key" required>
                      <option value="">Select Attribute</option>
                      <option value="is_new_arrival">New Arrival</option>
                      <option value="is_popular">Popular Product</option>
                      <option value="product_discount">Product Discount</option>
                    </select>
                  </div>

                  <!-- Dynamic Value Area -->
                  <div class="col-md-5" id="attribute_value_container">
                    <!-- Default is Yes/No -->
                    <select name="value" class="form-select" id="attribute_value_select" required>
                      <option value="">Attribute Value</option>
                      <option value="1">Yes</option>
                      <option value="0">No</option>
                    </select>

                    <!-- Hidden discount input -->
                    <input type="number" step="0.01" min="0" name="value" class="form-control d-none" id="attribute_value_input" placeholder="Enter Discount" />
                  </div>
                  <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Add</button>
                  </div>
                </div>
              </form>

              <hr>

              <table class="table table-bordered mt-3 text-center">
                <thead>
                  <tr class="text-center">
                    <th>Key</th>
                    <th>Value</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody id="attributeList">
                  <!-- Dynamically filled by AJAX -->
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </div>

      {{-- Add & Update Modal --}}
      <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="ProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="productForm" method="post" enctype="multipart/form-data">
              @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <i class="fa fa-clipboard fa-fw"></i>
                        <h5 class="modal-title">Product Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="productId">

                        <div class="mb-2"><label for="product_name">Product Name</label><span class="text-danger">*</span>
                          <input type="text" name="product_name" class="form-control" id="product_name" required>
                        </div>

                        <div class="mb-3"><label for="product_brand">Product Brand</label><span class="text-danger">*</span>
                          <select name="product_brand" id="product_brand" class="form-control form-select selectpicker" data-live-search="true" title="Select Brand" required>
                            <option value="">Select Brand</option>
                            @foreach($brands as $brand)
                              <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                            @endforeach
                          </select>
                        </div>

                        <div class="mb-3">
                          <label for="category_id">Product Category</label><span class="text-danger">* <small>(Multiple categories can be select)</small></span>
                          <select name="category_id[]" id="category_id" class="form-control form-select selectpicker" multiple data-live-search="true" title="Select Category" required>
                            <option value="">Select Product Category</option>
                            @foreach($categories as $category)
                              <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                          </select>
                        </div>

                        <div class="mb-3">
                          <label for="subcategory_id">Product Sub Category</label> <small class="text-danger">(Multiple sub categories can be select)</small></span>
                          <select name="subcategory_id[]" id="subcategory_id" class="form-control form-select selectpicker" multiple data-live-search="true" title="Select Sub Category">
                            <option value="">Select Product Sub Category</option>
                            @foreach($subCategories as $subcategory)
                              <option value="{{ $subcategory->id }}">{{ $subcategory->subcategory_name }}</option>
                            @endforeach
                          </select>
                        </div>

                        <div class="mb-2"><label>Feature Photo</label>
                          <input type="file" name="feature_photo" class="form-control" id="feature_image" accept=".png,.jpg,.jpeg,.ico,.gif">

                          <img id="feature_image_preview" class="img-thumbnail mt-2" src="" style="max-width: 100px;">
                        </div>

                        <div class="mb-2"><label>Other Photo</label> <small class="text-danger">(Multiple image can be select)</small>
                          <input type="file" name="other_photos[]" class="form-control" id="other_photos" accept=".png,.jpg,.jpeg,.ico,.gif" multiple>

                          <div id="other_photos_preview" class="mt-2 d-flex flex-wrap gap-2"></div>
                        </div>

                        <div class="mb-2"><label>Sort Description</label><span class="text-danger">*</span>
                          <input type="text" name="sort_desc" class="form-control" id="sort_desc" required>
                        </div>

                        <div class="mb-3"><label>Detail Description</label>
                          <textarea name="detail_desc" class="form-control" id="detail_desc" rows="4"></textarea>
                        </div>

                        <div class="col-md-12 col-lg-12 col-sm-12 d-flex gap-2 mb-3">
                          <div class="col-md-6 col-lg-6 col-sm-6">
                            <label>Stock</label><span class="text-danger">*</span>
                            <input type="number" step="0.00" min="0" name="stock" class="form-control" id="stock" required>
                          </div>
                          <div class="col-md-6 col-lg-6 col-sm-6">
                            <label>Model Number</label>
                            <input type="text" name="model_no" class="form-control" id="model_no">
                          </div>
                        </div>

                        <div class="col-md-12 col-lg-12 col-sm-12 d-flex gap-2 mb-3">
                          <div class="col-md-6 col-lg-6 col-sm-6">
                            <label>Actual Price</label><span class="text-danger">*</span>
                            <input type="number" name="price" step="0.00" min="0" class="form-control" id="price" required>
                          </div>
                          <div class="col-md-6 col-lg-6 col-sm-6">
                            <label>Discount Price</label>
                            <input type="number" name="discount_price" step="0.00" min="0" class="form-control" id="discount_price">
                          </div>
                        </div>

                        <div class="col-md-12 col-lg-12 col-sm-12 d-flex gap-2 mb-3">
                          <div class="col-md-6 col-lg-6 col-sm-6">
                            <label>Tax</label>
                            <select name="tax" id="tax" class="form-control form-select">
                              <option value="">Select Tax</option>
                              @foreach($taxSlabs as $tax)
                                <option value="{{ $tax->tax }}">{{ $tax->tax }}%</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="col-md-6 col-lg-6 col-sm-6">
                            <label>SKU</label>
                            <input type="text" name="sku" class="form-control" id="sku">
                          </div>
                        </div>

                        <div class="col-md-12 col-lg-12 col-sm-12 d-flex gap-2 mb-3">
                          <div class="col-md-6 col-lg-6 col-sm-6">
                            <label>Features</label>
                            <input type="text" name="features" class="form-control" id="features">
                          </div>
                          <div class="col-md-6 col-lg-6 col-sm-6">
                            <label>Movement</label>
                            <input type="text" name="movement" class="form-control" id="movement">
                          </div>
                        </div>

                        <div class="col-md-12 col-lg-12 col-sm-12 d-flex gap-2 mb-3">
                          <div class="col-md-6 col-lg-6 col-sm-6">
                            <label>Calibre</label>
                            <input type="text" name="calibre" class="form-control" id="calibre">
                          </div>
                          <div class="col-md-6 col-lg-6 col-sm-6">
                            <label>Series</label>
                            <input type="text" name="series" class="form-control" id="series">
                          </div>
                        </div>

                        <div class="col-md-12 col-lg-12 col-sm-12 d-flex gap-2 mb-3">
                          <div class="col-md-6 col-lg-6 col-sm-6">
                            <label>Case Size</label>
                            <input type="text" name="case_size" class="form-control" id="case_size">
                          </div>
                          <div class="col-md-6 col-lg-6 col-sm-6">
                            <label>Case Shape</label>
                            <input type="text" name="case_shape" class="form-control" id="case_shape">
                          </div>
                        </div>

                        <div class="col-md-12 col-lg-12 col-sm-12 d-flex gap-2 mb-3">
                          <div class="col-md-6 col-lg-6 col-sm-6">
                            <label>Case Material</label>
                            <input type="text" name="case_material" class="form-control" id="case_material">
                          </div>
                          <div class="col-md-6 col-lg-6 col-sm-6">
                            <label>Dial Color</label>
                            <input type="text" name="dial_color" class="form-control" id="dial_color">
                          </div>
                        </div>

                        <div class="col-md-12 col-lg-12 col-sm-12 d-flex gap-2 mb-3">
                          <div class="col-md-6 col-lg-6 col-sm-6">
                            <label>Strap Type</label>
                            <input type="text" name="strap_type" class="form-control" id="strap_type">
                          </div>
                          <div class="col-md-6 col-lg-6 col-sm-6">
                            <label>Strap Color</label>
                            <input type="text" name="strap_color" class="form-control" id="strap_color">
                          </div>
                        </div>

                        <div class="mb-2"  id="statusField" style="display: none;">
                          <label>Status</label>
                          <select name="status" id="product_status" class="form-control form-select">
                            <option value="">Select Product Status</option>
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
        <table id="productTable" class="table table-stripped text-center table-bordered align-middle table-nowrap mb-0">
          <thead>
            <tr>
              <th class="text-center">Sr. No.</th>
              <th class="text-center">Product Code</th>
              <th class="text-center">Product Name</th>
              <th class="text-center">Product Image</th>
              <th class="text-center">Other Images</th>
              <th class="text-center">Product Attribute</th>
              <th class="text-center">Product Brand</th>
              <th class="text-center">Category</th>
              <th class="text-center">Sub Category</th>
              <th class="text-center">Stock</th>
              <th class="text-center">Sort Description</th>
              <th class="text-center">Detail Description</th>
              <th class="text-center">Actual Price</th>
              <th class="text-center">Discount Price</th>
              <th class="text-center">Tax</th>
              <th class="text-center">Model Number</th>
              <th class="text-center">SKU</th>
              <th class="text-center">Features</th>
              <th class="text-center">Movement</th>
              <th class="text-center">Calibre</th>
              <th class="text-center">Series</th>
              <th class="text-center">Case Size</th>
              <th class="text-center">Case Shape</th>
              <th class="text-center">Case Material</th>
              <th class="text-center">Dial Color</th>
              <th class="text-center">Strap Type</th>
              <th class="text-center">Strap Color</th>
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

  $('#productTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route("products.data") }}',
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'product_code', name: 'product_code' },
        { data: 'product_name', name: 'product_name' },
        { data: 'feature_photo', name: 'feature_photo', orderable: false, searchable: false },
        { data: 'other_images', name: 'other_images', orderable: false, searchable: false },
        { data: 'product_attribute', name: 'product_attribute', orderable: false, searchable: false },
        { data: 'brand_name', name: 'brand.brand_name' },
        { data: 'category_name', name: 'category.category_name' },
        { data: 'subcategory_name', name: 'subcategory.subcategory_name' },
        { data: 'stock', name: 'stock' },
        { data: 'sort_desc', name: 'sort_desc' },
        { data: 'detail_desc', name: 'detail_desc' },
        { data: 'price', name: 'price' },
        { data: 'discount_price', name: 'discount_price' },
        { data: 'tax', name: 'tax' },
        { data: 'model_no', name: 'model_no' },
        { data: 'sku', name: 'sku' },
        { data: 'features', name: 'features.features' },
        { data: 'movement', name: 'features.movement' },
        { data: 'calibre', name: 'features.calibre' },
        { data: 'series', name: 'features.series' },
        { data: 'case_size', name: 'features.case_size' },
        { data: 'case_shape', name: 'features.case_shape' },
        { data: 'case_material', name: 'features.case_material' },
        { data: 'dial_color', name: 'features.dial_color' },
        { data: 'strap_type', name: 'features.strap_type' },
        { data: 'strap_color', name: 'features.strap_color' },
        { data: 'status', name: 'status', orderable: false, searchable: false },
        { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
    dom: 'Blfrtip',
    buttons: [
        'csv', 'excel', 'pdf'
    ],
    lengthMenu: [[10, 25, 50, 100, 200, 500, -1], [10, 25, 50, 100, 200, 500, "All"]]
  });

  // According to attribute show input fields
  $('#attribute_key').on('change', function () {
    const selectedAttr = $(this).val();

    if (selectedAttr === 'product_discount') {
      // Show number input
      $('#attribute_value_input').removeClass('d-none').attr('required', true);
      $('#attribute_value_select').addClass('d-none').removeAttr('required');
    } else {
      // Show Yes/No select
      $('#attribute_value_select').removeClass('d-none').attr('required', true);
      $('#attribute_value_input').addClass('d-none').removeAttr('required');
    }
  });

  
  let productId = null;

  // Open modal
  $(document).on('click', '.product-attributes-btn', function () {
    productId = $(this).data('product-id');
    $('#product_id').val(productId);
    $('#productAttributesModal').modal('show');
    fetchAttributes(productId);
  });

  // Fetch attributes
  function fetchAttributes(id) {
    $.get(`/products/${id}/attributes`, function (response) {
      let html = '';
      response.forEach(attr => {
        let inputField = '';

        if (attr.key === 'product_discount') {
          // Number input for discount
          inputField = `<input type="number" class="form-control attr-value" value="${attr.value}" step="0.00" min="0">`;
        } else {
          // Yes/No dropdown
          inputField = `
            <select class="form-select attr-value">
              <option value="1" ${attr.value == '1' ? 'selected' : ''}>Yes</option>
              <option value="0" ${attr.value == '0' ? 'selected' : ''}>No</option>
            </select>
          `;
        }

        html += `
          <tr data-id="${attr.id}" class="text-center">
            <td>
              <select class="form-select attr-key">
                <option value="is_new_arrival" ${attr.key === 'is_new_arrival' ? 'selected' : ''}>New Arrival</option>
                <option value="is_popular" ${attr.key === 'is_popular' ? 'selected' : ''}>Top Product</option>
                <option value="product_discount" ${attr.key === 'product_discount' ? 'selected' : ''}>Product Discount</option>
              </select>
            </td>
            <td class="attr-value-container">
              ${inputField}
            </td>
            <td>
              <button class="btn btn-primary mr-2 update-attr"><i class="mdi mdi-pencil"></i></button>
              <button class="btn btn-danger delete-attr"><i class="mdi mdi-delete"></i></button>
            </td>
          </tr>
        `;
      });
      $('#attributeList').html(html);
    });
  }

  // Change product attribute
  $(document).on('change', '.attr-key', function () {
    const selectedAttr = $(this).val();
    const row = $(this).closest('tr');
    const valueContainer = row.find('.attr-value-container');

    let newInput = '';

    if (selectedAttr === 'product_discount') {
      newInput = `<input type="number" class="form-control attr-value" value="" step="0.01" min="0">`;
    } else {
      newInput = `
        <select class="form-select attr-value">
          <option value="1">Yes</option>
          <option value="0">No</option>
        </select>
      `;
    }

    valueContainer.html(newInput);
  });

  // Add attribute
  $('#addAttributeForm').submit(function (e) {
    e.preventDefault();

    const key = $('#attribute_key').val();
    const value = $('#attribute_value_select').is(':visible')
      ? $('#attribute_value_select').val()
      : $('#attribute_value_input').val();

    const formData = {
      key,
      value,
      _token: $('#csrf_token').val()
    };

    const productId = $('#product_id').val();

    $.post(`/products/${productId}/attributes`, formData)
      .done(function () {
        fetchAttributes(productId);
        $('#addAttributeForm')[0].reset();
        $('#attribute_value_input').addClass('d-none'); // Hide input
        $('#attribute_value_select').removeClass('d-none'); // Reset to default
      })
      .fail(function (xhr) {
        alert('Error saving attribute');
        console.error(xhr.responseText);
      });
  });

  // Update attribute
  $(document).on('click', '.update-attr', function () {
    const row = $(this).closest('tr');
    const id = row.data('id');
    const key = row.find('.attr-key').val();
    const value = row.find('.attr-value').val();
    const token = $('#csrf_token').val();

    $.ajax({
      url: `/product-attributes/${id}`,
      type: 'PUT',
      headers: {
        'X-CSRF-TOKEN': token
      },
      data: { key, value },
      success: function () {
        alert('Attribute updated.');
      },
      error: function (xhr) {
        alert('Failed to update.');
        console.error(xhr.responseText);
      }
    });
  });

  // Delete attribute
  $(document).on('click', '.delete-attr', function () {
    if (!confirm('Are you sure?')) return;

    const row = $(this).closest('tr');
    const id = row.data('id');
    const token = $('#csrf_token').val();

    $.ajax({
      url: `/product-attributes/${id}`,
      type: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': token
      },
      success: function () {
        row.remove();
      },
      error: function (xhr) {
        alert('Failed to delete.');
        console.error(xhr.responseText);
      }
    });
  });
});

// View product other photos
$(document).on('click', '.view-photos-btn', function(e) {
  e.preventDefault();
  
  const productId = $(this).data('product-id');
  const $modal = $('#photosModal');
  
  // Show loading state
  $('#productPhotosContainer').html(`
      <div class="w-100 text-center py-5">
          <div class="spinner-border text-primary" role="status">
              <span class="sr-only">Loading...</span>
          </div>
          <p>Loading photos...</p>
      </div>
  `);
  
  // Show modal
  $modal.modal('show');
  
  // Load photos via AJAX
$.get(`/products/${productId}/photos`)
  .done(function(photos) {
    if (photos.length > 0) {
      let html = '';
      photos.forEach(photo => {
        html += `
          <div class="position-relative m-2" style="width: 150px;">
            <img src="${photo.photo}" class="img-thumbnail w-100" style="height: 150px; object-fit: cover;">
            <button class="btn btn-danger btn-sm delete-photo-btn" 
                style="position: absolute; top: 5px; right: 5px;"
                data-photo-id="${photo.id}">
              <i class="fas fa-trash"></i>
            </button>
          </div>
        `;
      });
      $('#productPhotosContainer').html(html);
    } else {
      $('#productPhotosContainer').html('<p class="text-center w-100 py-3">No photos available</p>');
    }
  })
  .fail(function() {
    $('#productPhotosContainer').html(`
      <div class="alert alert-danger w-100">
        Error loading photos
      </div>
    `);
  });
});
    
// Delete photo handler
$(document).on('click', '.delete-photo-btn', function() {
  if (!confirm('Are you sure you want to delete this photo?')) return;
  
  const photoId = $(this).data('photo-id');
  const $photoDiv = $(this).closest('div');
  
  $.ajax({
    url: `/product_other_photo/${photoId}`,
    method: 'POST',
    data: {
        _method: 'DELETE', // simulate DELETE
        _token: $('meta[name="csrf-token"]').attr('content')
    },
    success: function () {
        $photoDiv.remove();
        alert('Photo deleted successfully');
    },
    error: function () {
        alert('Error deleting photo');
    }
  });
});
</script>
