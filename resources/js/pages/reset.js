$(document).ready(function(){
    $('#reset-form').validate({
        rules: {
            password: {
                required: true
            },
            re_password: {
                required: true,
                equalTo: '#password'
            }
        },
        showErrors: formErrorDisplay,
        submitHandler: function (ev) {
            var btn = $('.reset-submit');
            $.ajax({
                url: baseUri,
                method: 'POST',
                dataType: 'json',
                async: false,
                data: {
                    action: 'UPDATE_PASSWORD_FORGOT',
                    uID: btn.data('id'),
                    password: $('#password').val()
                },
                beforeSend: function (){
                    btn.prop('disabled', true);
                },
                success: function (response) {
                    if (response.status === "success") {
                        $('.reset-form-wrapper').hide();
                        $('.successful-reset-wrapper').slideToggle();
                    }else{
                        btn.prop('disabled', false);
                        $.jnoty("Password cannot be reset at this time, please try again later...", {
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
});