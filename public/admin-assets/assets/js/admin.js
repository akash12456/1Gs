$(document).ready(function () {
 
    $.validator.addMethod("customEmailValidation", function (value, element) {
        return /\S+@\S+\.\S+/.test(value);
    }, "Please enter a valid email address");

    $.validator.addMethod("noSpaces", function (value, element) {
        return value.trim().length > 0;
    }, "This field cannot be empty.");

   
    $('.select_destinations').select2(
        {
            placeholder: 'Select multiple destinations',
            allowClear: true
        }
    );

    $('.select_verticals').select2(
        {
            placeholder: 'Select multiple verticals',
            allowClear: true
        }
    );
 
  
  
   
     

    $(document).on('click', '.edit_affiliate_btn', function (event) {
        event.preventDefault();  
     
        var id = $(this).data('id');
        var affiliate_name = $(this).data('affiliate_name');
        var affiliate_link = $(this).data('affiliate_link');
        var image = $(this).data('affiliate_image');
        var img_path = $(this).data('img_path');
        var status = $(this).data('status');
     
        $('#affiliate_modal').modal('show'); 
        $('#affiliate_modal').find('form').attr("id", "edit_affiliate");
        $('#affiliate_modal').find('form').attr("action", base_url + 'affiliate-update');
    
        
        $('#affiliate_modal #imgPreview').attr('src', img_path + '/' + image).show();
        $('#affiliate_modal #imgPreview').attr('src', image); 
        $('#affiliate_modal #affiliate_name').val(affiliate_name);
        $('#affiliate_modal #affiliate_link').val(affiliate_link);
        $('#affiliate_modal #status').val(status);
     
        $('#affiliate_modal #affiliate_modal_title').text("Edit affiliate");
        $('#affiliate_modal #affiliate_submit_btn').text("Update");
     
        $('#affiliate_modal input[name="affiliate_id"]').remove();
        var affiliate_id_input = '<input type="hidden" name="affiliate_id" value="' + id + '" class="affiliate_id">';
        $('#affiliate_modal form').append(affiliate_id_input);
    });
    

   


    $('.edit_user_btn').on('click', function (event) {
        event.preventDefault(event)

        var id = $(this).data('id');
        var brand_name = $(this).data('brand_name');
        var email = $(this).data('email');
        var status = $(this).data('status');

        $('#user_modal').modal('show');
        $('#user_modal').find('form').attr("id", "edit_brand_form");
        $('#user_modal').find('form').attr("action", base_url + 'admin/user-update');
        $('#user_modal #brand_name').val(brand_name);
        $('#user_modal #email').val(email);
        $('#user_modal #status').val(status);

        $('#user_modal #user_modal_title').text("Edit brand");
        $('#user_modal .password_div').hide();
        $('#user_modal #user_submit_btn').text("Update");
        var brand_id = '<input type="hidden" name="brand_id" value=' + id + ' class="brand_id">';
        $("#brand_name").after(brand_id);

    });

    
 
    $('.modal').on('hidden.bs.modal', function () { 
         
         if ($(this).find('form').attr("id") == 'affiliate_store' || $(this).find('form').attr("id") == 'edit_affiliate') { 
             
            $(this).find('form').attr("id", "affiliate_store");
            $(this).find('form').attr("action", base_url + 'admin/affiliate.store');
            $('.affiliate_id').remove();
            var form = $('#affiliate_store');
            form.validate().resetForm();
            $(this).find('form').trigger('reset');
            form.find('.error').removeClass('error');
            form.find('.is-invalid').removeClass('is-invalid');
            form.find('.is-valid').removeClass('is-valid');  
            form.find('img').attr('src', '');  
            form.find('#imgPreview').css('display', 'none');
            form.find('input[type="file"]').val(''); 
            $('#affiliate_modal #affiliate_modal_title').text("Add affiliate"); 
            $('#affiliate_modal #affiliate_submit_btn').text("Submit"); 
        } 
      
    });
    
     

    $("#change_password_admin").validate({
        rules: {
            current_password: {
                required: true,
                minlength: 8,
                noSpaces: true

            },
            password: {
                required: true,
                minlength: 8,
                noSpaces: true

            },
            password_confirmation: {
                required: true,
                equalTo: "#password",
                minlength: 8,
                noSpaces: true


            }
        },
        messages: {
            current_password: {
                required: 'Please enter current password'
            },
            password: {
                required: 'Please enter new password'
            },
            password_confirmation: {
                required: 'Please enter confirmation password',
                equalTo: 'Password not match'
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.col-sm-10').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        }
    });



    $("#admin_deatils").validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
                noSpaces: true
            },
            email: {
                required: true,
                email: true,
                customEmailValidation: true
            },
        },
        messages: {
            name: {
                required: 'Please enter name'
            },
            email: {
                required: 'Please enter email'
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.col-sm-10').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        }
    });

 



    $("#affiliate_store,#edit_affiliate").validate({
        rules: {
            affiliate_name: {
                required: true,
                minlength: 3,
                noSpaces: true
            },
            affiliate_link: {
                required: true,
                minlength: 3,
                noSpaces: true
            }
        },
        messages: {
            affiliate_name: {
                required: 'Please enter Affiliate name'
            },
            affiliate_link: {
                required: 'Please enter Affiliate Link'
            }
        }, errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        }
    });

   

    


   

    $(function () {
        $('.summernote').summernote({
            dialogsInBody: true,
            height: 100,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear', 'fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']],
            ],
    
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Poppins'],
            fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '24', '36']
        });
        $('#description,#summernote').summernote({
            height: 100,
            dialogsInBody: true,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear', 'fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']],
            ],
    
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Poppins'],
            fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '24', '36']
    
        });
        $('.summernote_fullheight').summernote({
            dialogsInBody: true,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear', 'fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']],
            ],
    
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Poppins'],
            fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '24', '36']
    
        });
    });


});
