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