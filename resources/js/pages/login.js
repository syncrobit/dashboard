$(document).ready(function (){
    var $login_form = $('#login-form');
    $login_form.validate({
        rules: {
            username: {
                required: true
            },
            password: {
                required: true
            }
        },
        showErrors: formErrorDisplay,
        submitHandler: function (ev) {
            var btn = $('.login-button');
            $login_form.validate();
            if($login_form.valid()){
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
                            window.location = response.redirect;
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
        }
    });

    var $forgot_from = $('#forgot-pwd-form');
    $forgot_from.validate({
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
        showErrors: formErrorDisplay,
        submitHandler: function (ev) {
            $forgot_from.validate();
            if($forgot_from.valid()){
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
        }
    });

    $('#forgot-pwd').on('hidden.bs.modal', function () {
        $forgot_from.find('input').val('')
            .removeClass("parsley-error")
            .data("title", "")
            .tooltip("dispose");
    });
})