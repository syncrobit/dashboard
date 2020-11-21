$(document).ready(function (){
    $('#register_user').validate({
        rules: {
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            email:{
                required: true,
                email: true,
                remote: {
                    url: baseUri,
                    type: 'POST',
                    async: false,
                       data: {
                        action: 'CHECK_EMAIL',
                        email: function() {
                            return $("#email").val();
                        }
                    },
                }
            },
            username:{
                required: true,
                remote: {
                    url: baseUri,
                    type: 'POST',
                    async: false,
                     data: {
                         action: 'CHECK_USERNAME',
                         username: function() {
                             return $("#username").val();
                         }
                     },
                }
            },
            password:{
                required: true
            },
            re_pass:{
                required: true,
                equalTo: '#password'
            },
            tnc:{
                required: true,
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
                    action: 'REGISTER_USER',
                    username: $('#username').val(),
                    password: $('#password').val(),
                    email: $('#email').val(),
                    first_name: $('#first_name').val(),
                    last_name: $('#last_name').val()
                },
                beforeSend: function (){
                    $('.registration-error').hide();
                    $('.other-error').hide();
                    $('.btn-register').prop('disabled', true);
                    $('.button-label').hide();
                    $('.button-spinner').show();
                },
                success: function (response) {
                    if (response.status === "success") {
                        window.location = '/inactive/';
                    }else if(response.status === "email_exits"){
                        $('.button-label').show();
                        $('.button-spinner').hide();
                        $('.btn-register').prop('disabled', false);

                        $('.email').tooltip("dispose") // Destroy any pre-existing tooltip so we can repopulate with new tooltip content
                            .data("title", 'Email already exists!')
                            .addClass("parsley-error")
                            .tooltip({placement : 'right'}); // Create a new tooltip based on the error message we just set in the title
                    }else if(response.status === "username_exits"){
                        $('.button-label').show();
                        $('.button-spinner').hide();
                        $('.btn-register').prop('disabled', false);

                        $('.username').tooltip("dispose") // Destroy any pre-existing tooltip so we can repopulate with new tooltip content
                            .data("title", 'Username already exists!')
                            .addClass("parsley-error")
                            .tooltip({placement : 'right'}); // Create a new tooltip based on the error message we just set in the title
                    }else{
                        $('.button-label').show();
                        $('.button-spinner').hide();
                        $('.registration-error').show();
                        $('.other-error').show();
                        $('.btn-register').prop('disabled', false);
                    }
                }
            });
        }

    });
});