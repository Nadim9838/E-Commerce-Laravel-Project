$(document).ready(function() {
    // Animate elements on scroll
    $(window).scroll(function() {
        $('.register-card').each(function() {
            var cardPosition = $(this).offset().top;
            var scrollPosition = $(window).scrollTop() + $(window).height();
            
            if (scrollPosition > cardPosition + 100) {
                $(this).addClass('animate');
            }
        });

        $('.profile-card').each(function() {
            var cardPosition = $(this).offset().top;
            var scrollPosition = $(window).scrollTop() + $(window).height();
            
            if (scrollPosition > cardPosition + 100) {
                $(this).addClass('animate');
            }
        });
    });

    /**
     * Show calender modal popup
     */
    $('#dob').on('focus', function () {
    this.showPicker && this.showPicker();
    });
    
    // Email validation
    $('#email').on('blur', function() {
        var email = $(this).val();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email && !emailRegex.test(email)) {
            $(this).addClass('is-invalid');
            $(this).next('.invalid-feedback').text('Please enter a valid email address');
            $(this).next('.invalid-feedback').show();
        } else {
            $(this).removeClass('is-invalid');
        }
    });
    
    // Mobile number validation
    $('#mobile').on('blur', function() {
        var mobile = $(this).val();
        var mobileRegex = /^[0-9]{10,15}$/;
        
        if (mobile && !mobileRegex.test(mobile)) {
            $(this).addClass('is-invalid');
            $(this).next('.invalid-feedback').text('Please enter a valid mobile number (10-15 digits)');
        } else {
            $(this).removeClass('is-invalid');
        }
    });
    
    // Confirm password validation
    $('#confirm-password').on('input', function() {
        if ($(this).val() !== $('#password').val()) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });
    
    // Form validation
    $('#registerForm').submit(function(e) {
        e.preventDefault();
        
        var isValid = true;
        var form = this;
        var required = false;
        
        // Reset all invalid states
        $(this).find('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').hide();
        
        // Check each required field
        $(this).find('[required]').each(function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                isValid = false;
                required = true;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if(required) {
            toastr.error('Please fill all required fields.');
            return;
        }

        // Check password match
        if ($('#password').val() !== $('#confirm-password').val()) {
            $('#confirm-password').addClass('is-invalid');
            toastr.error('The password and confirmation do not match.');
            isValid = false;
            return;
        }
        
        // Check terms checkbox
        if (!$('#terms').is(':checked')) {
            $('#terms').addClass('is-invalid');

            toastr.error('You must agree to the terms.');
            isValid = false;
            return;
        }
        
        if (isValid) {
            // Show loading state
            $('.btn-register').prop('disabled', true);
            $('.btn-text').text('Processing...');
            
            var formData = new FormData(this);            
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            
            // AJAX submission
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message);
                        setTimeout(() => {
                            window.location.href = response.redirect;
                        }, 1000);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    if(xhr.status === 422) { // Validation error
                        var errors = xhr.responseJSON.errors;
                        var errorMessages = [];
                        
                        // Display errors under each field
                        $.each(errors, function(field, messages) {
                            var $field = $('[name="' + field + '"]');
                            var $feedback = $field.next('.invalid-feedback');
                            
                            // For select elements
                            if($field.length === 0) {
                                $field = $('#' + field);
                                $feedback = $field.next('.invalid-feedback');
                            }
                            
                            $field.addClass('is-invalid');
                            $feedback.text(messages[0]).show();
                            
                            // Collect all error messages for toast
                            errorMessages.push(messages[0]);
                        });
                        
                        // Show all errors in toastr
                        if(errorMessages.length > 0) {
                            toastr.error(errorMessages.join('<br>'), 'Validation Errors', {
                                timeOut: 10000, // 10 seconds
                                extendedTimeOut: 5000,
                                closeButton: true,
                                progressBar: true,
                                newestOnTop: true,
                                preventDuplicates: true
                            });
                        }
                        
                        // Scroll to first error
                        $('html, body').animate({
                            scrollTop: $('.is-invalid').first().offset().top - 100
                        }, 500);
                    } else {
                        // Other errors (500, 404, etc.)
                        toastr.error(
                            xhr.responseJSON.message || 'An error occurred. Please try again.',
                            'Error', 
                            {
                                timeOut: 8000,
                                closeButton: true
                            }
                        );
                    }
                },
                complete: function() {
                    $('.btn-register').prop('disabled', false);
                    $('.btn-text').text('Create Account');
                }
            });
        } else {
            $('html, body').animate({
                scrollTop: $('.is-invalid').first().offset().top - 100
            }, 500);
        }
    });
    
    // Remove invalid class when user starts typing
    $('input').on('input', function() {
        if ($(this).val()) {
            $(this).removeClass('is-invalid');
        }
    });
    
    // Initialize animations
    setTimeout(function() {
        $('.register-card').addClass('animate');
    }, 500);

    // Profile edit script

    // Toggle between view and edit modes
    const $editBtn = $('#editProfileBtn');
    const $cancelBtn = $('#cancelEditBtn');
    const $viewMode = $('#profileView');
    const $editMode = $('#profileEdit');
    
    if ($editBtn.length && $cancelBtn.length) {
        $editBtn.on('click', function() {
            $viewMode.hide();
            $editMode.show();
        });
        
        $cancelBtn.on('click', function() {
            $editMode.hide();
            $viewMode.show();
        });
    }
    
    // Avatar upload preview
    const $avatarUpload = $('#avatarUpload');
    const $avatarImage = $('#avatarImage');
    const profileId = $('#profileId').val();
    
    if ($avatarUpload.length && $avatarImage.length) {
        $avatarUpload.on('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                if(profileId == '') {
                    toastr.error('Your profile id not found.');
                    return;
                }
                reader.onload = function(event) {
                    $avatarImage.attr('src', event.target.result);
                    
                    // Upload the image to the server
                    const formData = new FormData();
                    formData.append('profile_image', e.target.files[0]);
                    formData.append('id', profileId);
                    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                    
                    $.ajax({
                        url: 'client/profile_image',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            if (data.success) {
                                // Avatar updated successfully
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                };
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
    
    const $profileForm = $('#profileEdit');
    
    if ($profileForm.length) {
        $profileForm.on('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const $submitBtn = $(this).find('button[type="submit"]');
            
            // Show loading state
            $submitBtn.prop('disabled', true).text('Updating...');

            $.ajax({
            url: '/profile/update',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            success: function(data) {
                if (data.success) {
                    toastr.success(data.message);
                    // Update view mode with new data
                    $('#viewName').text(data.user.name);
                    $('#viewEmail').text(data.user.email);
                    $('#viewPhone').text(data.user.phone || 'Not provided');
                    
                    if (data.user.dob) {
                        const dobDate = new Date(data.user.dob);
                        $('#viewDob').text(dobDate.toLocaleDateString('en-US', { 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric' 
                        }));
                    } else {
                        $('#viewDob').text('Not provided');
                    }
                    
                    $('#viewAddress').text(data.user.address || 'No address saved');
                    $('#viewCity').text(data.user.city || '--');
                    $('#viewState').text(data.user.state || '--');
                    $('#viewZip').text(data.user.zip_code || '--');
                    $('#viewCountry').text(data.user.country || '--');
                    
                    // Switch back to view mode
                    $editMode.hide();
                    $viewMode.show();
                } else {
                    alert('Error updating profile: ' + (data.message || 'Please try again'));
                }
            },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Validation errors
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            const $field = $('[name="' + field + '"]');
                            $field.addClass('is-invalid');
                            $field.next('.invalid-feedback').text(messages[0]).show();
                        });
                    } else {
                        alert('An error occurred while updating your profile');
                    }
                },
                complete: function() {
                    $submitBtn.prop('disabled', false).text('Update Profile');
                }
            });
        });
    }

    // Login form submission
    $('#loginForm').submit(function(e) {
        e.preventDefault();
        
        // Reset error states
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').hide();
        
        // Get form data
        var formData = $(this).serialize();
        
        // Show loading state
        $('.btn-register').prop('disabled', true);
        $('.btn-text').text('Signing In...');
        
        // AJAX request
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    setTimeout(() => {
                        window.location.href = response.redirect;
                    }, 1000);
                } else {
                    // Show error message
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    toastr.error(xhr.responseJSON.message || 'Validation failed. Please check your inputs.');
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(field, messages) {
                        var inputField = $('[name="' + field + '"]');
                        inputField.addClass('is-invalid');
                        
                        var errorElement = inputField.next('.invalid-feedback');
                        if (errorElement.length === 0) {
                            errorElement = $('<div class="invalid-feedback">').insertAfter(inputField);
                        }
                        errorElement.text(messages[0]).show();
                    });
                } else {
                    toastr.error(xhr.responseJSON.message || 'Login failed. Please try again.');
                }
            },
            complete: function() {
                // Reset button state
                $('.btn-register').prop('disabled', false);
                $('.btn-text').text('Sign In');
            }
        });
    });
});