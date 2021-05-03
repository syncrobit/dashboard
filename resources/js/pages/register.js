$(document).ready(function (){

    $.validator.addMethod("validUsername", function (value, element) {
        return /^[a-zA-Z0-9_.-]+$/.test(value);
    }, "Please enter a valid username");

    var $register_from = $('#register_user');
    $register_from.validate({
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
                validUsername: true,
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
                required: true,
                minlength: 8
            },
            re_pass:{
                required: true,
                equalTo: '#password'
            },
            tnc:{
                required: true,
            }
        },
        showErrors: formErrorDisplay,
        submitHandler: function (ev) {
            $register_from.validate()
            if($register_from.valid()){
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

                            $('.email').tooltip("dispose")
                                .data("title", 'Email already exists!')
                                .addClass("parsley-error")
                                .tooltip({
                                    template: '<div class="tooltip tooltip-primary" role="tooltip"><div class="arrow"><\/div><div class="tooltip-inner"><\/div><\/div>',
                                    placement : 'right'
                                }); 
                        }else if(response.status === "username_exits"){
                            $('.button-label').show();
                            $('.button-spinner').hide();
                            $('.btn-register').prop('disabled', false);

                            $('.username').tooltip("dispose") 
                                .data("title", 'Username already exists!')
                                .addClass("parsley-error")
                                .tooltip({
                                    template: '<div class="tooltip tooltip-primary" role="tooltip"><div class="arrow"><\/div><div class="tooltip-inner"><\/div><\/div>',
                                    placement : 'right'
                                }); 
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
        }

    });

    $('#password').passtrength({
        minChars: 8,
        passwordToggle: false,
        tooltip: false
      });
});