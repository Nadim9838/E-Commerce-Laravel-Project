$(document).ready(function () {
  /**
   * Datatable initialization
   */
  $('#dataTable').DataTable({
    dom: 'Blfrtip',
    buttons: [
        'csv', 'excel', 'pdf'
    ],
    lengthMenu: [[10, 25, 50, 100, 200, 500, -1], [10, 25, 50, 100, 200, 500, "All"]],
    pageLength: 10,
    lengthChange: true,
    ordering: true,
    searching: true,
    language: {
      search: "_INPUT_",
      searchPlaceholder: "Search details..."
    }
  });

  $('.selectpicker').selectpicker();

  /**
   * Initialize the selectpicker
   */
  $('#category_id').selectpicker();

  /**
   * Fadeout alert message after 30 sec
   */
  setTimeout(function () {
    $('.alert').fadeOut('slow', function () {
        $(this).remove();
    });
  }, 30000);
  
  /**
   * Show calender modal popup
   */
  $('.date').on('focus', function () {
    this.showPicker && this.showPicker();
  });

  /**
   * Image upload instructions
   */
  $('input[type="file"][id$="_image"], input[type="file"][id$="_logo"]').each(function() {
    const $input = $(this);
    const $preview = $('#' + $input.attr('id') + '_preview');
    const instructionHtml = `
        <div class="instruction-box animate__animated animate__fadeIn">
            <div class="d-flex align-items-center">
                <div class="instruction-icon me-2">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div class="instruction-text small">
                    <span class="d-block">Please upload an image with:</span>
                    <ul>
                        <li>Maximum size: <span class="text-danger">2MB</span></li>
                        <li>Allowed formats: <span class="text-success">${getAllowedExtensions($input)}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    `;
    
    $input.after(instructionHtml);
    
    // Add initial animation
    $input.next('.instruction-box').addClass('pulse-animation');
    
    // File change event
    $input.on('change', function() {
        validateImageUpload($(this), $preview);
    });
  });

  // Remove initial animation after 6 seconds
  setTimeout(function() {
    $('.instruction-box').removeClass('pulse-animation');
  }, 6000);

  function getAllowedExtensions($input) {
    const accept = $input.attr('accept') || '';
    return accept.replace(/\./g, '').split(',').filter(Boolean).join(', ');
  }

  // Function to validate image
  function validateImageUpload($input, $preview) {
    const file = $input[0].files[0];
    const $instructionBox = $input.next('.instruction-box');

    if (file) {
      // Check file size (2MB = 2097152 bytes)
      if (file.size > 2097152) {
          showUploadMessage($instructionBox, 'File size exceeds 2MB limit!', 'error');
          $input.val('');
          $preview.hide();
          return;
      }
      
      // Check file extension
      const validExtensions = $input.attr('accept').replace(/\./g, '').split(',').map(ext => ext.trim());
      const fileExt = file.name.split('.').pop().toLowerCase();
      
      if (!validExtensions.includes(fileExt)) {
          showUploadMessage($instructionBox, `Only ${getAllowedExtensions($input)} files are allowed!`, 'error');
          $input.val('');
          $preview.hide();
          return;
      }
      
      // If valid, show success and preview
      showUploadMessage($instructionBox, 'File is valid!', 'success');
      
      // Image preview
      const reader = new FileReader();
      reader.onload = function(e) {
          $preview.attr('src', e.target.result).show();
      }
      reader.readAsDataURL(file);
    }
  }

  // Show image upload message
  function showUploadMessage($element, message, type) {
    const iconClass = type === 'error' ? 'fa-exclamation-circle' : 'fa-check-circle';
    const textClass = type === 'error' ? 'text-danger' : 'text-success';

    $element.html(`
      <div class="d-flex align-items-center ${textClass}">
          <div class="me-2"><i class="fas ${iconClass}"></i></div>
          <div class="small">${message}</div>
      </div>
    `).removeClass('instruction-error instruction-success')
    .addClass(`instruction-${type} animate__animated ${type === 'error' ? 'animate__headShake' : 'animate__bounceIn'}`);

    setTimeout(function() {
      $element.removeClass('animate__animated animate__headShake animate__bounceIn');
    }, 1000);
  }

  /**
   * Delete confirmation alert popup
   */
  $(document).on('submit', '.delete-confirmation', function (e) {
    e.preventDefault();
    
    const form = this;
    Swal.fire({
      title: 'Are you sure?',
      text: "This action will delete the record.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit();
      }
    });
  });
  
  // Mobile number input field validation
  $('.mobile_validation').on('input', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
      if (this.value.length > 10) {
        this.value = this.value.slice(0, 10);
      }
    });
    
    // User management script
    const addUser = "add_user";
    const updateUser = "update_user/"; 
    
  // Handle add user button
  $('#addUserBtn').on('click', function () {
    $('#userForm')[0].reset();
    $('#userId').val('');
    $('#user_image_preview').attr('src', '');
    $('#userForm').attr('action', addUser);
    $('#userModal .modal-title').text('Add New User');
    $('#statusField').hide();
    $('#userModal').modal('show');
  });

  // Handle edit button click
  $(document).on('click', '.user-btn-edit', function () {
    const user = $(this).data('user');
    $('#userId').val(user.id);
    $('#name').val(user.name);
    $('#email').val(user.email);
    $('#mobile').val(user.mobile);
    const userImage = user.user_image ? `/storage/${user.user_image}` : '';
    $('#user_image_preview').attr('src', userImage);
    $('#branch_name').val(user.branch_name);
    $('#branch_code').val(user.branch_code);
    $('#role').val(user.role);
    $('#user_status').val(user.status);

    $('#password').val(user.password);
    $('#password_confirmation').val(user.password);

    $('#userForm').attr('action', updateUser + user.id);
  
    $('#userModal .modal-title').text('Update User Details');
    $('#statusField').show();
    $('#userModal').modal('show');
  });

  // Client-side validation
  $('#userForm').on('submit', function (e) {
    e.preventDefault();

    let isValid = true;
    let errorMessage = '';
    $('#userForm input, #userForm select').removeClass('is-invalid');

    // Required fields validation
    $('#userForm [required]').each(function () {
      if (!$(this).val()) {
        isValid = false;
        $(this).addClass('is-invalid');
      } else {
        $(this).removeClass('is-invalid');
      }
    });

    // Confirm password validation
    let password = $('#password').val();
    let confirmPassword = $('#password_confirmation').val();
    if (password !== confirmPassword) {
      isValid = false;
      errorMessage += 'Passwords do not match.\n';
    }

    // Email Validation
    const email = $('#email').val();
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email && !emailPattern.test(email)) {
      isValid = false;
      $('#email').addClass('is-invalid');
      errorMessage += 'Please enter a valid email address.\n';
    }

    if (!isValid) {
      alert(errorMessage || 'Please fill in all required fields correctly.');
      return;
    }

    this.submit();
  });

  // Branch management script
  const addBranch = "add_branch";
  const updateBranch = "update_branch/"; 

  // Handle add branch button
  $('#addBranchBtn').on('click', function () {
    $('#branchForm')[0].reset();
    $('#branchId').val('');
    $('#branch_logo_preview').attr('src', '');
    $('#branchForm').attr('action', addBranch);
    $('#branchModal .modal-title').text('Add New Branch');
    $('#statusField').hide();
    $('#branchModal').modal('show');
  });

  // Handle edit button click
  $(document).on('click', '.branch-btn-edit', function () {
    const branch = $(this).data('branch');
    $('#branchId').val(branch.id);
    $('#branch_code').val(branch.branch_code);
    $('#branch_name').val(branch.name);
    $('#branch_email').val(branch.email);
    $('#branch_mobile').val(branch.number);
    $('#login_id').val(branch.login_id);
    $('#branch_password').val(branch.password);
    const logoPath = branch.branch_logo ? branch.branch_logo : '';
    $('#branch_logo_preview').attr('src', logoPath);
    $('#branch_address').val(branch.address);
    $('#branch_gst_no').val(branch.gst_no);
    $('#branch_support_email').val(branch.support_email);
    $('#branch_support_number').val(branch.support_number);
    $('#branch_status').val(branch.status);
    $('#branchForm').attr('action', updateBranch + branch.id);
  
    $('#branchModal .modal-title').text('Update Branch Details');
    $('#statusField').show();
    $('#branchModal').modal('show');
  });

  // Client-side validation
  $('#branchForm').on('submit', function (e) {
    e.preventDefault();

    let isValid = true;
    let errorMessage = '';
    $('#branchForm input, #branchForm select').removeClass('is-invalid');

    // Required fields validation
    $('#branchForm [required]').each(function () {
      if (!$(this).val()) {
        isValid = false;
        $(this).addClass('is-invalid');
      } else {
        $(this).removeClass('is-invalid');
      }
    });

    // Email Validation
    const email = $('#branch_email').val().trim();
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email && !emailPattern.test(email)) {
      isValid = false;
      $('#branch_email').addClass('is-invalid');
      errorMessage += 'Please enter a valid email address.\n';
    }

    // Support email Validation
    const supportEmail = $('#branch_support_email').val();
    if (supportEmail && !emailPattern.test(supportEmail)) {
      isValid = false;
      $('#branch_support_email').addClass('is-invalid');
      errorMessage += 'Please enter a valid email address.\n';
    }

     // GST Number validation
    const gstRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
    const gstNumber = $('#branch_gst_no').val().toUpperCase().trim(); // sanitize input

    if (gstNumber && !gstRegex.test(gstNumber)) {
      isValid = false;
      $('#branch_gst_no').addClass('is-invalid');
      errorMessage += 'Invalid GST number format.';
    }
    
    // Image Validation (type and size)
    const fileInput = $('#branch_logo')[0];
    if (fileInput.files.length > 0) {
      const file = fileInput.files[0];
      const allowedTypes = ['image/png', 'image/jpeg', 'image/jpg'];
      const maxSize = 3 * 1024 * 1024; // 3 MB

      if (!allowedTypes.includes(file.type)) {
        isValid = false;
        errorMessage += 'Only PNG, JPG, and JPEG image formats are allowed.\n';
        $('#branch_logo').addClass('is-invalid');
      } else if (file.size > maxSize) {
        isValid = false;
        errorMessage += 'Image size must be less than 3MB.\n';
        $('#branch_logo').addClass('is-invalid');
      }
    }

    if (!isValid) {
      alert(errorMessage || 'Please fill in all required fields correctly.');
      return;
    }

    this.submit();
  });
  
  // Client management script
  const addClient = "add_client";
  const updateClient = "update_client/"; 

  // Handle add client button
  $('#addClientBtn').on('click', function () {
    $('#clientForm')[0].reset();
    $('#clientId').val('');
    $('#clientForm').attr('action', addClient);
    $('#clientModal .modal-title').text('Add New Client');
    $('#statusField').hide();
    $('#clientModal').modal('show');
  });

  $(document).on('click', '.client-btn-edit', function () {
    const clientId = $(this).data('id');

    $.ajax({
        url: `/clients/${clientId}/show`,
        method: 'GET',
        success: function(client) {
          console.log(client)
            $('#clientId').val(client.id);
            $('#client_name').val(client.name);
            $('#client_email').val(client.email);
            $('#client_number').val(client.mobile);
            $('#client_age').val(client.age);
            $('#client_gender').val(client.gender);
            $('#client_status').val(client.status);
            $('#clientForm').attr('action', updateClient + client.id);

            // Addresses (assuming first one for edit, or loop them as needed)
            if (client.address.length > 0) {
                const address = client.address[0];
                $('#client_address').val(address.address);
                $('#client_city').val(address.city);
                $('#client_state').val(address.state);
                $('#client_country').val(address.country);
                $('#client_zip_code').val(address.zip_code);
            }

            $('#clientModal .modal-title').text('Update Client Details');
            $('#statusField').show();
            $('#clientModal').modal('show');
        }
    });
});
  // Client-side validation
  $('#clientForm').on('submit', function (e) {
    e.preventDefault();

    let isValid = true;
    let errorMessage = '';
    $('#clientForm input, #clientForm select').removeClass('is-invalid');

    // Required fields validation
    $('#clientForm [required]').each(function () {
      if (!$(this).val()) {
        isValid = false;
        $(this).addClass('is-invalid');
      } else {
        $(this).removeClass('is-invalid');
      }
    });

    if (!isValid) {
      alert(errorMessage || 'Please fill in all required fields correctly.');
      return;
    }

    this.submit();
  });

  // Coupon management script
  const addCoupon = "add_coupon";
  const updateCoupon = "update_coupon/";

  // Handle add coupon button
  $('#addCouponBtn').on('click', function () {
    $('#couponForm')[0].reset();
    $('#couponId').val('');
    $('#couponForm').attr('action', addCoupon);
    $('#couponModal .modal-title').text('Add New Coupon');
    $('#statusField').hide();
    $('#couponModal').modal('show');
  });

  // Handle edit button click
  $(document).on('click', '.coupon-btn-edit', function () {
    const coupon = $(this).data('coupon');
    $('#couponId').val(coupon.id);
    $('#coupon_code').val(coupon.coupon_code);
    $('#coupon_name').val(coupon.coupon_name);
    $('#offer').val(coupon.offer);
    $('#terms_condition').val(coupon.terms_condition);
    $('#validity').val(coupon.validity);
    $('#no_of_time').val(coupon.no_of_time);
    $('#coupon_status').val(coupon.status);
    $('#couponForm').attr('action', updateCoupon + coupon.id);
  
    $('#couponModal .modal-title').text('Update Coupon Details');
    $('#statusField').show();
    $('#couponModal').modal('show');
  });

  // Coupon-side validation
  $('#couponForm').on('submit', function (e) {
    e.preventDefault();

    let isValid = true;
    let errorMessage = '';
    $('#couponForm input, #couponForm select').removeClass('is-invalid');

    // Required fields validation
    $('#couponForm [required]').each(function () {
      if (!$(this).val()) {
        isValid = false;
        $(this).addClass('is-invalid');
      } else {
        $(this).removeClass('is-invalid');
      }
    });

    if (!isValid) {
      alert(errorMessage || 'Please fill in all required fields correctly.');
      return;
    }

    this.submit();
  });

  // Category management script
  const addCategory = "add_category";
  const updateCategory = "update_category/"; 

  // Handle add category button
  $('#addCategoryBtn').on('click', function () {
    $('#categoryForm')[0].reset();
    $('#categoryId').val('');
    $('#category_image_preview').attr('src', '');
    $('#categoryForm').attr('action', addCategory);
    $('#categoryModal .modal-title').text('Add New Category');
    $('#statusField').hide();
    $('#categoryModal').modal('show');
  });

  // Handle edit button click
  $(document).on('click', '.category-btn-edit', function () {
    const category = $(this).data('category');
    $('#categoryId').val(category.id);
    $('#category_code').val(category.category_code);
    $('#category_name').val(category.category_name);
    const categoryPath = category.category_image ? category.category_image : '';
    $('#category_image_preview').attr('src', categoryPath);
    $('#meta_title').val(category.meta_title);
    $('#meta_tags').val(category.meta_tags);
    $('#meta_keywords').val(category.meta_keywords);
    $('#category_status').val(category.status);
    $('#categoryForm').attr('action', updateCategory + category.id);
  
    $('#categoryModal .modal-title').text('Update Category Details');
    $('#statusField').show();
    $('#categoryModal').modal('show');
  });

  // Client-side validation
  $('#categoryForm').on('submit', function (e) {
    e.preventDefault();

    let isValid = true;
    let errorMessage = '';
    $('#categoryForm input, #categoryForm select').removeClass('is-invalid');

    // Required fields validation
    $('#categoryForm [required]').each(function () {
      if (!$(this).val()) {
        isValid = false;
        $(this).addClass('is-invalid');
      } else {
        $(this).removeClass('is-invalid');
      }
    });

    if (!isValid) {
      alert(errorMessage || 'Please fill in all required fields correctly.');
      return;
    }

    this.submit();
  });
  
  // SubCategory management script
  const addSubCategory = "add_subcategory";
  const updateSubCategory = "update_subcategory/";
  const originalOptions = $('#category_id').html();

  // Handle add category button
  $('#addSubCategoryBtn').on('click', function () {
    $('#subCategoryForm')[0].reset();
    $('#subCategoryId').val('');
    $('#subcategory_image_preview').attr('src', '');
    $('#subCategoryForm').attr('action', addSubCategory);
    $('#subCategoryModal .modal-title').text('Add New Sub Category');
    $('#statusField').hide();
    $('#subCategoryModal').modal('show');
  });

  $(document).on('click', '.subcategory-btn-edit', function () {
    const subcategory = $(this).data('category');

    // Reset form and restore original options
    $('#subCategoryForm')[0].reset();
    $('#category_id').html(originalOptions);
    
    // Set form values
    $('#subCategoryId').val(subcategory.id);
    $('#subcategory_code').val(subcategory.subcategory_code);
    $('#subcategory_name').val(subcategory.subcategory_name);
    $('#subcategory_image_preview').attr('src', subcategory.subcategory_image || '');
    $('#meta_title').val(subcategory.meta_title);
    $('#meta_tags').val(subcategory.meta_tags);
    $('#meta_keywords').val(subcategory.meta_keywords);
    $('#subcategory_status').val(subcategory.status);
    $('#subCategoryForm').attr('action', updateSubCategory + subcategory.id);
    
    // Handle category selection - destroy and recreate selectpicker
    $('#category_id').val(subcategory.category.id);
    $('#category_id').selectpicker('destroy').selectpicker();
    
    // Show modal
    $('#subCategoryModal .modal-title').text('Update Sub Category Details');
    $('#statusField').show();
    $('#subCategoryModal').modal('show');
  });
  
  // Add new category button handler
  $('#addSubCategoryBtn').click(function() {
    $('#subCategoryForm')[0].reset();
    $('#category_id').html(originalOptions);
    $('#category_id').val('').selectpicker('destroy').selectpicker();
    $('#subCategoryModal .modal-title').text('Add New Sub Category');
    $('#statusField').hide();
    $('#subCategoryForm').attr('action', 'add_subcategory');
    $('#subCategoryModal').modal('show');
  });
  
  // Clean up when modal closes
  $('#subCategoryModal').on('hidden.bs.modal', function () {
    $('#subCategoryForm')[0].reset();
    $('#category_id').html(originalOptions);
    $('#category_id').val('').selectpicker('refresh');
  });

  // Client-side validation
  $('#subCategoryForm').on('submit', function (e) {
    e.preventDefault();

    let isValid = true;
    let errorMessage = '';
    $('#subCategoryForm input, #subCategoryForm select').removeClass('is-invalid');

    // Required fields validation
    $('#subCategoryForm [required]').each(function () {
      if (!$(this).val()) {
        isValid = false;
        $(this).addClass('is-invalid');
      } else {
        $(this).removeClass('is-invalid');
      }
    });

    if (!isValid) {
      alert(errorMessage || 'Please fill in all required fields correctly.');
      return;
    }

    this.submit();
  });
  
  // Brand management script
  const addBrand = "add_brand";
  const updateBrand = "update_brand/"; 

  // Handle add brand button
  $('#addBrandBtn').on('click', function () {
    $('#brandForm')[0].reset();
    $('#brandId').val('');
    $('#brand_image_preview').attr('src', '');
    $('#brandForm').attr('action', addBrand);
    $('#brandModal .modal-title').text('Add New Brand');
    $('#statusField').hide();
    $('#brandModal').modal('show');
  });

  // Handle edit button click
  $(document).on('click', '.brand-btn-edit', function () {
    const brand = $(this).data('brand');
    $('#brandId').val(brand.id);
    $('#brand_name').val(brand.brand_name);
    const brandPath = brand.brand_image ? brand.brand_image : '';
    $('#brand_image_preview').attr('src', brandPath);
    $('#meta_title').val(brand.meta_title);
    $('#meta_tags').val(brand.meta_tags);
    $('#meta_keywords').val(brand.meta_keywords);
    $('#brand_status').val(brand.status);
    $('#brandForm').attr('action', updateBrand + brand.id);
  
    $('#brandModal .modal-title').text('Update Brand Details');
    $('#statusField').show();
    $('#brandModal').modal('show');
  });

  // Client-side validation
  $('#brandForm').on('submit', function (e) {
    e.preventDefault();

    let isValid = true;
    let errorMessage = '';
    $('#brandForm input, #brandForm select').removeClass('is-invalid');

    // Required fields validation
    $('#brandForm [required]').each(function () {
      if (!$(this).val()) {
        isValid = false;
        $(this).addClass('is-invalid');
      } else {
        $(this).removeClass('is-invalid');
      }
    });

    if (!isValid) {
      alert(errorMessage || 'Please fill in all required fields correctly.');
      return;
    }

    this.submit();
  });
  
  // Product management script
  const addProduct = "add_product";
  const updateProduct = "update_product/"; 

  // Handle add product button
  $('#addProductBtn').on('click', function () {
    $('#product_brand, #category_id, #subcategory_id').selectpicker('destroy');
    $('#productForm')[0].reset();
    $('#productId').val('');
    $('#product_brand').val('');
    $('#category_id').val([]);
    $('#subcategory_id').val([]);
    $('#product_brand, #category_id, #subcategory_id').selectpicker();
    $('#feature_image_preview').attr('src', '');
    $('#other_photos_preview').html('');
    $('#productForm').attr('action', addProduct);
    $('#productModal .modal-title').text('Add New Product');
    $('#statusField').hide();
    $('#productModal').modal('show');
  });

  // Product other photos preview on file input change
  $('#other_photos').on('change', function () {
    const validTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'image/x-icon'];
    const maxSize = 2 * 1024 * 1024; // 2MB

    const files = this.files;
    $('#other_photos_preview').html(''); // Clear previews

    for (const file of files) {
      // Validate file type
      if (!validTypes.includes(file.type)) {
        alert(`File "${file.name}" is not a valid image type. Allowed types are PNG, JPG, JPEG, GIF, ICO.`);
        $(this).val(''); // Clear input
        $('#other_photos_preview').html('');
        return;
      }

      // Validate file size
      if (file.size > maxSize) {
        alert(`File "${file.name}" is too large. Max size allowed is 2MB.`);
        $(this).val('');
        $('#other_photos_preview').html('');
        return;
      }

      // If valid, preview
      const reader = new FileReader();
      reader.onload = function (e) {
        $('#other_photos_preview').append(
          `<img src="${e.target.result}" class="img-thumbnail" style="max-width: 100px; margin: 5px;">`
        );
      };
      reader.readAsDataURL(file);
    }
  });

  // Handle edit button click
  $(document).on('click', '.product-btn-edit', function () {
    try {
      $('#category_id, #subcategory_id').selectpicker('destroy');

      const product = JSON.parse($(this).attr('data-product'));
      let features = {};
      if ($(this).attr('data-features')) {
        features = JSON.parse($(this).attr('data-features')) || {};
      }

      $('#productForm')[0].reset();
      $('#productId').val(product.id);
      $('#product_code').val(product.product_code);
      $('#product_name').val(product.product_name);

      // Feature image
      const featureImagePath = product.feature_photo || '';
      $('#feature_image_preview').html('');
      $('#feature_image_preview').attr('src', featureImagePath);
      $('#feature_photo_preview').toggle(!!featureImagePath);

      // Other photos preview
      $('#other_photos_preview').html(''); // Clear previous previews

      if (product.photos && product.photos.length > 0) {
          product.photos.forEach(photo => {
              $('#other_photos_preview').append(`
                  <div class="photo-thumbnail-wrapper">
                      <img src="${photo.photo}" class="img-thumbnail" style="max-width: 100px; margin: 5px;">
                      <button type="button" class="btn btn-sm btn-danger remove-photo" data-photo-id="${photo.id}">
                          <i class="fa fa-times"></i>
                      </button>
                  </div>
              `);
          });
      }

      $('#stock').val(product.stock);
      $('#sort_desc').val(product.sort_desc);
      $('#detail_desc').val(product.detail_desc);
      $('#price').val(product.price);
      $('#tax').val(product.tax);
      $('#discount_price').val(product.discount_price);
      $('#model_no').val(product.model_no);
      $('#sku').val(product.sku);
      
      $('#features').val(features.features || '');
      $('#movement').val(features.movement || '');
      $('#calibre').val(features.calibre || '');
      $('#series').val(features.series || '');
      $('#case_size').val(features.case_size || '');
      $('#case_shape').val(features.case_shape || '');
      $('#case_material').val(features.case_material || '');
      $('#dial_color').val(features.dial_color || '');
      $('#strap_type').val(features.strap_type || '');
      $('#strap_color').val(features.strap_color || '');
      $('#product_status').val(product.status);
      $('#productForm').attr('action', updateProduct + product.id);
      
      $('#product_brand').val(product.brands.id);
      $('#product_brand').selectpicker('destroy').selectpicker();

      // Set categories (multiple select)
      if (product.categories && product.categories.length > 0) {
        const categoryIds = product.categories.map(cat => cat.id);
        $('#category_id').val(categoryIds);
      }

      // Set subcategories (multiple select)
      if (product.sub_categories && product.sub_categories.length > 0) {
        const subcategoryIds = product.sub_categories.map(sub => sub.id);
        $('#subcategory_id').val(subcategoryIds);
      }

      // Reinitialize selectpickers after setting values
      $('#category_id, #subcategory_id').selectpicker();
        

      $('#productModal .modal-title').text('Update Product Details');
      $('#statusField').show();
      $('#productModal').modal('show');
    } catch (error) {
        console.error('Error loading product data:', error);
        alert('Error loading product data. Please try again.');
    }
  });

  // Handle photo removal
  $(document).on('click', '.remove-photo', function() {
      const photoId = $(this).data('photo-id');
      if (confirm('Are you sure you want to remove this photo?')) {
          $.ajax({
              url: '/remove-product-photo/' + photoId,
              method: 'DELETE',
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              success: function(response) {
                  $(`button[data-photo-id="${photoId}"]`).closest('.photo-thumbnail-wrapper').remove();
              },
              error: function(xhr) {
                  alert('Error removing photo: ' + xhr.responseJSON.message);
              }
          });
      }
  });

  // Client-side validation
  $('#productForm').on('submit', function (e) {
    e.preventDefault();

    let isValid = true;
    let errorMessage = '';
    $('#productForm input, #productForm select').removeClass('is-invalid');

    // Required fields validation
    $('#productForm [required]').each(function () {
      if (!$(this).val()) {
        isValid = false;
        $(this).addClass('is-invalid');
      } else {
        $(this).removeClass('is-invalid');
      }
    });

    if (!isValid) {
      alert(errorMessage || 'Please fill in all required fields correctly.');
      return;
    }

    this.submit();
  });
  
  // Banner image script
  const addBanner = "add_banner";
  const updateBanner = "update_banner/"; 

  // Handle add banner button
  $('#addBannerBtn').on('click', function () {
    $('#bannerForm')[0].reset();
    $('#bannerId').val('');
    $('#banner_image_preview').attr('src', '');
    $('#bannerForm').attr('action', addBanner);
    $('#bannerModal .modal-title').text('Add New Banner Image');
    $('#bannerModal').modal('show');
  });

  // Handle edit button click
  $(document).on('click', '.banner-btn-edit', function () {
    const banner = $(this).data('banner');
    $('#bannerId').val(banner.id);
    $('#title').val(banner.title);
    $('#desc').val(banner.desc);
    const bannerPath = banner.banner_image ? banner.banner_image : '';
    $('#banner_image_preview').attr('src', bannerPath);
    $('#bannerForm').attr('action', updateBanner + banner.id);
  
    $('#bannerModal .modal-title').text('Update Banner Image Details');
    $('#bannerModal').modal('show');
  });

  // Client-side validation
  $('#bannerForm').on('submit', function (e) {
    e.preventDefault();

    let isValid = true;
    let errorMessage = '';
    $('#bannerForm input, #bannerForm select').removeClass('is-invalid');

    // Required fields validation
    $('#bannerForm [required]').each(function () {
      if (!$(this).val()) {
        isValid = false;
        $(this).addClass('is-invalid');
      } else {
        $(this).removeClass('is-invalid');
      }
    });

    if (!isValid) {
      alert(errorMessage || 'Please fill in all required fields correctly.');
      return;
    }

    this.submit();
  });

  // Tax slab script
  const addTax = "add_tax";
  const updateTax = "update_tax/"; 

  // Handle add tax button
  $('#addTaxBtn').on('click', function () {
    $('#taxForm')[0].reset();
    $('#taxId').val('');
    $('#taxForm').attr('action', addTax);
    $('#taxModal .modal-title').text('Add New Tax Slab');
    $('#taxModal').modal('show');
  });

  // Handle edit button click
  $(document).on('click', '.tax-btn-edit', function () {
    const tax = $(this).data('tax');
    $('#taxId').val(tax.id);
    $('#tax').val(tax.tax);
    $('#taxForm').attr('action', updateTax + tax.id);
  
    $('#taxModal .modal-title').text('Update Tax Slab Details');
    $('#taxModal').modal('show');
  });

  // Client-side validation
  $('#taxForm').on('submit', function (e) {
    e.preventDefault();

    let isValid = true;
    let errorMessage = '';
    $('#taxForm input, #taxForm select').removeClass('is-invalid');

    // Required fields validation
    $('#taxForm [required]').each(function () {
      if (!$(this).val()) {
        isValid = false;
        $(this).addClass('is-invalid');
      } else {
        $(this).removeClass('is-invalid');
      }
    });

    if (!isValid) {
      alert(errorMessage || 'Please fill in all required fields correctly.');
      return;
    }

    this.submit();
  });

  // Special offer script
  const addSetting = "add_setting";
  const updateSetting = "update_setting/"; 

  // Handle add banner button
  $('#addSettingBtn').on('click', function () {
    $('#settingForm')[0].reset();
    $('#settingId').val('');
    $('#special_offer_image_preview').attr('src', '');
    $('#settingForm').attr('action', addSetting);
    $('#settingModal .modal-title').text('Add Offer Details');
    $('#settingModal').modal('show');
  });

  // Handle edit button click
  $(document).on('click', '.setting-btn-edit', function () {
    const setting = $(this).data('setting');
    $('#settingId').val(setting.id);
    $('#title').val(setting.title);
    $('#sub_title').val(setting.sub_title);
    $('#description').val(setting.description);
    const settingPath = setting.offer_image ? setting.offer_image : '';
    $('#special_offer_image_preview').attr('src', settingPath);
    $('#settingForm').attr('action', updateSetting + setting.id);
  
    $('#settingModal .modal-title').text('Update Special Offer Details');
    $('#settingModal').modal('show');
  });

  // Client-side validation
  $('#settingForm').on('submit', function (e) {
    e.preventDefault();

    let isValid = true;
    let errorMessage = '';
    $('#settingForm input, #settingForm select').removeClass('is-invalid');

    // Required fields validation
    $('#settingForm [required]').each(function () {
      if (!$(this).val()) {
        isValid = false;
        $(this).addClass('is-invalid');
      } else {
        $(this).removeClass('is-invalid');
      }
    });

    if (!isValid) {
      alert(errorMessage || 'Please fill in all required fields correctly.');
      return;
    }

    this.submit();
  });

  // Banner image script
  const addReview = "add_review_banner";
  const updateReview = "update_review_banner/"; 

  // Handle add banner button
  $('#addReviewBtn').on('click', function () {
    $('#reviewForm')[0].reset();
    $('#reviewId').val('');
    $('#review_banner_image_preview').attr('src', '');
    $('#reviewForm').attr('action', addReview);
    $('#reviewModal .modal-title').text('Add New Review Banner Image');
    $('#reviewModal').modal('show');
  });

  // Handle edit button click
  $(document).on('click', '.review-btn-edit', function () {
    const review = $(this).data('review');
    $('#reviewId').val(review.id);
    const bannerPath = review.banner_image ? review.banner_image : '';
    $('#review_banner_image_preview').attr('src', bannerPath);
    $('#reviewForm').attr('action', updateReview + review.id);
  
    $('#reviewModal .modal-title').text('Update Review Banner Image');
    $('#reviewModal').modal('show');
  });

  // Client-side validation
  $('#reviewForm').on('submit', function (e) {
    e.preventDefault();

    let isValid = true;
    let errorMessage = '';
    $('#reviewForm input, #reviewForm select').removeClass('is-invalid');

    // Required fields validation
    $('#reviewForm [required]').each(function () {
      if (!$(this).val()) {
        isValid = false;
        $(this).addClass('is-invalid');
      } else {
        $(this).removeClass('is-invalid');
      }
    });

    if (!isValid) {
      alert(errorMessage || 'Please fill in all required fields correctly.');
      return;
    }

    this.submit();
  });
});