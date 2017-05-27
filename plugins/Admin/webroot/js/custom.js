$(document).ready(function(){
    var ajaxLoaderObj = $("#ajax_loader");
    var mediumModal   = $("#mediumModal");
    var mediumModalContent = $("#mediumModalContent");
    
    function appAlert(alertTxt) {
		$('#appAlert #appAlertTextId').html(alertTxt);
		$('#appAlert').modal('show');
	}
    
    $('.table-responsive').on('show.bs.dropdown', function () {
        $('.table-responsive').css( "overflow", "inherit" );
    });
    
    $('.table-responsive').on('hide.bs.dropdown', function () {
        $('.table-responsive').css( "overflow", "auto" );
    });
    
    $.validator.addMethod("regex", function(value, element, regexp) {
        return this.optional(element) || regexp.test(value);
    },"Please check your input.");
    
    // Admin login validations
    $("#admin_login_form").validate({
        errorClass: 'error-message',
        rules: {
            'email': {
                required: true,
                email: true
            },
            'password': {
                required: true
            }
        },
        messages: {
            'email': {
                required: 'Please enter valid email address.',
                email: 'Please enter valid email address.'
            },
            'password': {
                required: 'Please enter a valid password.'
            }
        }
    });
    
    // Admin forgot password validations
    $("#admin_forgot_password_form").validate({
        errorClass: 'error-message',
        rules: {
            'email': {
                required: true,
                email: true,
                remote: {
                    url: BASE_URL+'admin/auths/is-email-exists',
                    type: "POST"
                }
            }
        },
        messages: {
            'email': {
                required: 'Please enter a email address.',
                email: 'Please enter a valid email address.',
                remote: 'Please enter a registered email address.'
            }
        }
    });
    
    // Admin reset password validations
    $("#admin_reset_password_form").validate({
        errorClass: 'error-message',
        rules: {
            'password': {
                required: true,
                minlength: 8,
                maxlength: 30
            },
            'confirm_password': {
                required: true,
                maxlength: 30,
                equalTo: '#password'
            }
        },
        messages: {
            'password': {
                required: 'New password is required.',
                minlength: 'New password must be atleast 8 characters long.',
                maxlength: 'New password must be atmost 30 characters long.'
            },
            'confirm_password': {
                required: 'Confirm password is required.',
                maxlength: 'Confirm password must be between 8 and 30 characters long.',
                equalTo: 'New password and confirm password does not match.'
            }
        }
    });
    
    $(".user_status_action").on("click",function(){
        var thisObj = $(this);
        var user_id = thisObj.attr("data-id");
        $.ajax({
            url: BASE_URL + 'admin/users/change-status',
            type: "POST",
            data:{'user_id':user_id},
            beforeSend: function () {
                ajaxLoaderObj.show();
            },
            success: function (data) {
                data = $.parseJSON(data);
                ajaxLoaderObj.hide();
                if (data.result == 'success') {
                    thisObj.hide();
                    thisObj.closest("tr").find(".status-td").html(data.statusText);
                    if (data.statusText == "Inactive") {
                        thisObj.closest("tr").find(".user_active").show();
                    } else {
                        thisObj.closest("tr").find(".user_inactive").show();
                    }
                } else if(data.result == 'logout') {
                    setTimeout(function(){
                        window.location = BASE_URL+'admin/login';
                    },2000);
                }
                appAlert(data.message);
            },
            error: function(data) {
                ajaxLoaderObj.hide();
                appAlert(data.status+' - '+data.statusText);
            }
        });
        return false;
    });
    
    /* Admin change password starts */
    // Show admin change password popup
    $("#change_password_link").on("click",function(){
        $.ajax({
            url: BASE_URL + 'admin/auths/change-password',
            type: "GET",
            beforeSend: function () {
                ajaxLoaderObj.show();
            },
            success: function (data) {
                data = $.parseJSON(data);
                if (data.result == 'success') {
                    mediumModalContent.html(data.html);
                    validateAdminChangePasswordForm();
                    ajaxLoaderObj.hide();
                    mediumModal.modal("show");
                } else if(data.result == 'logout') {
                    ajaxLoaderObj.hide();
                    appAlert(data.message);
                    setTimeout(function(){
                        window.location = BASE_URL+'admin/login';
                    },2000);
                } else {
                    ajaxLoaderObj.hide();
                    appAlert(data.message);
                }
            },
            error: function(data) {
                ajaxLoaderObj.hide();
                appAlert(data.status+' - '+data.statusText);
            }
        });
        return false;
    });
    
    // Admin change password validations
    var validateAdminChangePasswordForm = function() {
        $("#admin_change_password_form").validate({
            errorClass: 'error-message',
            highlight: function(element) {
                $(element).parent().addClass("error");
                $('.server-side-error-msg').hide();
            },
            rules: {
                'old_password': {
                    required: true,
                    remote: {
                        url: BASE_URL+'admin/auths/is-valid-old-password',
                        type: "POST"
                    }
                },
                'new_password': {
                    required: true,
                    minlength: 8,
                    maxlength: 30
                },
                'confirm_password': {
                    required: true,
                    maxlength: 30,
                    equalTo: '#new-password'
                }
            },
            messages: {
                'old_password': {
                    required: 'Old password is required.',
                    remote: 'Please check your password and try again.'
                },
                'new_password': {
                    required: 'New password is required.',
                    minlength: 'New password must be atleast 8 characters long.',
                    maxlength: 'New password must be atmost 30 characters long.'
                },
                'confirm_password': {
                    required: 'Confirm password is required.',
                    maxlength: 'Confirm password must be between 8 and 30 characters long.',
                    equalTo: 'New password and confirm password does not match.'
                }
            }
        });
    };    
    
    $(document).on("submit","#admin_change_password_form",function(){
        //var thisObj = $(this);
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: BASE_URL + 'admin/auths/change-password',
            type: "POST",
            data: formData,
            beforeSend: function () {
                ajaxLoaderObj.show();
            },
            success: function (data) {
                data = $.parseJSON(data);
                //console.log(data);
                if (data.result == 'saved') {
                    location.reload();
                } else if (data.result == 'success') {
                    mediumModalContent.html(data.html);
                    validateAdminChangePasswordForm();
                    ajaxLoaderObj.hide();
                } else if(data.result == 'logout') {
                    ajaxLoaderObj.hide();
                    appAlert(data.message);
                    setTimeout(function(){
                        window.location = BASE_URL+'admin/login';
                    },2000);
                } else {
                    ajaxLoaderObj.hide();
                    appAlert(data.message);
                }
            },
            error: function(data) {
                ajaxLoaderObj.hide();
                appAlert(data.status+' - '+data.statusText);
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });
    /* Admin change password end */
    
    // Send reset password link to users
    $('.user_send_pass_link').on('click',function(){
        var thisObj = $(this);
        var user_id = thisObj.attr('data-id');
        $.ajax({
            url: BASE_URL + 'admin/users/sendPasswordLink',
            type: "POST",
            data: {'user_id': user_id},
            beforeSend: function () {
                ajaxLoaderObj.show();
            },
            success: function (data) {
                ajaxLoaderObj.hide();
                data = $.parseJSON(data);
                if (data.result == 'logout') {
                    appAlert(data.message);
                    setTimeout(function(){
                        window.location = BASE_URL+'admin/login';
                    },2000);
                }
                appAlert(data.message);
            },
            error: function(data) {
                ajaxLoaderObj.hide();
                appAlert(data.status+' - '+data.statusText);
            }
        });
        return false;
    });
    
    // User form validation
    $("#user_form").validate({
        errorClass: 'error-message',
        rules: {
            'role_id': {
                required: true
            },
            'email': {
                required: true,
                email: true,
                remote: {
                    url: BASE_URL+'admin/users/is-unique-email/'+$("#user_id").val(),
                    type: "POST"
                }
            },
            'first_name': {
                required: true,
                minlength: 2,
                maxlength: 50,
                regex: /^[a-zA-Z ]+$/
            },
            'last_name': {
                minlength: 2,
                maxlength: 50,
                regex: /^[a-zA-Z ]+$/
            },
            'phone': {
                minlength: 8,
                maxlength: 15,
                regex: /^\s*(?:\+?(\d{1,3}))?[- (]*(\d{3})[- )]*(\d{3})[- ]*(\d{4})(?: *[x/#]{1}(\d+))?\s*$/
            }
        },
        'messages': {
            'role_id': {
                required: 'Role is required.'
            },
            'email': {
                required: 'Email is required.',
                email: 'Please provide a valid email.',
                remote: 'This email is already used.'
            },
            'first_name': {
                required: 'First name is required.',
                minlength: 'First name should contain atleast {0} characters.',
                maxlength: 'First name should contain atmost {0} characters.',
                regex: 'First name should contain only characters.'
            },
            'last_name': {
                minlength: 'First name should contain atleast {0} characters.',
                maxlength: 'First name should contain atmost {0} characters.',
                regex: 'Last name should contain only characters.'
            },
            'phone': {
                minlength: 'Phone should contain atleast {0} digits.',
                maxlength: 'Phone should contain atmost {0} digits.',
                regex: 'Please enter a valid phone number.'
            }
        }
    });
    
    $("#admin_profile_form").validate({
        errorClass: 'error-message',
        rules: {
            'email': {
                required: true,
                email: true,
                remote: {
                    url: BASE_URL+'admin/users/is-unique-email/'+$("#user_id").val(),
                    type: "POST"
                }
            },
            'first_name': {
                required: true,
                minlength: 2,
                maxlength: 50,
                regex: /^[a-zA-Z ]+$/
            },
            'last_name': {
                minlength: 2,
                maxlength: 50,
                regex: /^[a-zA-Z ]+$/
            },
            'phone': {
                minlength: 8,
                maxlength: 15,
                regex: /^\s*(?:\+?(\d{1,3}))?[- (]*(\d{3})[- )]*(\d{3})[- ]*(\d{4})(?: *[x/#]{1}(\d+))?\s*$/
            }
        },
        'messages': {
            'email': {
                required: 'Email is required.',
                email: 'Please provide a valid email.',
                remote: 'This email is already used.'
            },
            'first_name': {
                required: 'First name is required.',
                minlength: 'First name should contain atleast {0} characters.',
                maxlength: 'First name should contain atmost {0} characters.',
                regex: 'First name should contain only characters.'
            },
            'last_name': {
                minlength: 'First name should contain atleast {0} characters.',
                maxlength: 'First name should contain atmost {0} characters.',
                regex: 'Last name should contain only characters.'
            },
            'phone': {
                minlength: 'Phone should contain atleast {0} digits.',
                maxlength: 'Phone should contain atmost {0} digits.',
                regex: 'Please enter a valid phone number.'
            }
        }
    });

    // Setting start
    var validateAdminSettingForm = function() {
        $("#admin_add_setting_form").validate({
            errorClass: 'error-message',
            rules: {
                'key_field': {
                    required: true,
                    minlength: 2,
                    maxlength: 100,
                    remote: {
                        url: BASE_URL+'admin/settings/is-unique-key/'+$("#setting_id").val(),
                        type: "POST"
                    }
                },
                'key_value': {
                    required: true,
                    minlength: 2,
                    maxlength: 250
                }
            },
            messages: {
                'key_field': {
                    required: 'Key field is required.',
                    minlength: 'Key should contain atleast 2 characters.',
                    maxlength: 'Key should contain atmost 100 characters.',
                    remote: 'This key is already used.'
                },
                'key_value': {
                    required: 'Value field is required.',
                    minlength: 'New password must be atleast {0} characters long.',
                    maxlength: 'New password must be atmost {0} characters long.'
                }
            }
        });
    };
    
    var getSettingForm = function(id) {
        $.ajax({
            url: BASE_URL + 'admin/save-settings/'+id,
            type: "GET",
            beforeSend: function () {
                ajaxLoaderObj.show();
            },
            success: function (data) {
                console.log(data);
                data = $.parseJSON(data);
                if (data.result == 'success') {
                    mediumModalContent.html(data.html);
                    validateAdminSettingForm();
                    ajaxLoaderObj.hide();
                    mediumModal.modal("show");
                } else if(data.result == 'logout') {
                    ajaxLoaderObj.hide();
                    appAlert(data.message);
                    setTimeout(function(){
                        window.location = BASE_URL+'admin/login';
                    },2000);
                } else {
                    ajaxLoaderObj.hide();
                    appAlert(data.message);
                }
            },
            error: function(data) {
                console.log(data);
                ajaxLoaderObj.hide();
                appAlert(data.status+' - '+data.statusText);
            }
        });
    };

    $("#add_new_setting").on("click",function(){
        getSettingForm(null);
        return false;
    });
    
    $(".edit_site_setting").on("click",function(){
        var id = $(this).attr("data-id");
        getSettingForm(id);
    });

    $(document).on("submit","#admin_add_setting_form",function(){
        var setting_id = $("#setting_id").val();
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: BASE_URL + 'admin/save-settings/'+setting_id,
            type: "POST",
            data: formData,
            beforeSend: function () {
                ajaxLoaderObj.show();
            },
            success: function (data) {
                data = $.parseJSON(data);
                if (data.result == 'saved') {
                    window.location = BASE_URL+'admin/settings/';
                    //location.reload();
                } else if (data.result == 'success') {
                    mediumModalContent.html(data.html);
                    //validateAdminChangePasswordForm();
                    ajaxLoaderObj.hide();
                } else if(data.result == 'logout') {
                    ajaxLoaderObj.hide();
                    appAlert(data.message);
                    setTimeout(function(){
                        window.location = BASE_URL+'admin/login';
                    },2000);
                } else {
                    ajaxLoaderObj.hide();
                    appAlert(data.message);
                }
            },
            error: function() {
                ajaxLoaderObj.hide();
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });
});