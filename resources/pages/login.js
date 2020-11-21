$(document).ready(function (){
    $('#login-form').validate({
        rules: {
            username: {
                required: true
            },
            password: {
                required: true
            }
        },
        showErrors: function(errorMap, errorList) {

            // Clean up any tooltips for valid elements
            $.each(this.validElements(), function (index, element) {
                var $element = $(element);

                $element.data("title", "") // Clear the title - there is no error associated anymore
                    .removeClass("parsley-error")
                    .tooltip("dispose");
            });

            // Create new tooltips for invalid elements
            $.each(errorList, function (index, error) {
                var $element = $(error.element);

                $element.tooltip("dispose") // Destroy any pre-existing tooltip so we can repopulate with new tooltip content
                    .data("title", error.message)
                    .addClass("parsley-error")
                    .tooltip({placement : 'right'}); // Create a new tooltip based on the error message we just set in the title
            });
        },
        submitHandler: function (ev) {
            var btn = $('.login-button');
            $.ajax({
                url: baseUri,
                method: 'POST',
                dataType: 'json',
                async: false,
                data: {
                    action: 'LOGIN',
                    username: $("#username").val(),
                    password: $("#password").val()
                },
                beforeSend: function (){
                    btn.prop('disabled', true);
                    $('.button-label').hide();
                    $('.button-spinner').show();
                },
                success: function (response) {
                    if (response.status === "success") {
                        window.location = '/overview/';
                    }else{
                        btn.prop('disabled', false);
                        $('.button-label').show();
                        $('.button-spinner').hide();

                        $.jnoty("Username/Password invalid.", {
                            header: 'Failed',
                            sticky: false,
                            theme: 'jnoty-danger',
                            icon: 'fa fa-check-circle'
                        });
                    }
                }
            });
        }
    });

    $('#forgot-pwd-form').validate({
        rules: {
            email: {
                required: true,
                email: true,
                remote: {
                    url: baseUri,
                    type: 'POST',
                    async: false,
                    data: {
                        action: 'CHECK_EMAIL_REVERSE',
                        email: function() {
                            return $("#email").val();
                        }
                    },
                }
            }
        },
        showErrors: function(errorMap, errorList) {

            // Clean up any tooltips for valid elements
            $.each(this.validElements(), function (index, element) {
                var $element = $(element);

                $element.data("title", "") // Clear the title - there is no error associated anymore
                    .removeClass("parsley-error")
                    .tooltip("dispose");
            });

            // Create new tooltips for invalid elements
            $.each(errorList, function (index, error) {
                var $element = $(error.element);

                $element.tooltip("dispose") // Destroy any pre-existing tooltip so we can repopulate with new tooltip content
                    .data("title", error.message)
                    .addClass("parsley-error")
                    .tooltip({placement : 'right'}); // Create a new tooltip based on the error message we just set in the title
            });
        },
        submitHandler: function (ev) {
            $.ajax({
                url: baseUri,
                method: 'POST',
                dataType: 'json',
                async: false,
                data: {
                    action: 'FORGOT_PASSWORD',
                    email: $("#email").val()
                },
                success: function (response) {
                    if (response.status === "success") {
                        $('#forgot-pwd').modal('hide');
                        $.jnoty("Email was successfully sent.", {
                            header: 'Success',
                            sticky: false,
                            theme: 'jnoty-success',
                            icon: 'fa fa-check-circle'
                        });
                    }else if(response.status === "email_not_exist"){
                        $.jnoty("Email not in database.", {
                            header: 'Failed',
                            sticky: false,
                            theme: 'jnoty-danger',
                            icon: 'fa fa-check-circle'
                        });
                    }else{
                        $.jnoty("Email could not be sent at this time.", {
                            header: 'Failed',
                            sticky: false,
                            theme: 'jnoty-danger',
                            icon: 'fa fa-check-circle'
                        });
                    }
                }
            });
        }
    });

    $('#forgot-pwd').on('hidden.bs.modal', function () {
        $('#forgot-pwd-form').find('input').val('')
            .removeClass("parsley-error")
            .data("title", "")
            .tooltip("dispose");
    });
})