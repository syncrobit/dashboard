$(document).ready(function() {
    var fewSeconds = 30;
    $('.resend-email').click(function () {
        var btn = $(this);

        $.ajax({
            url: baseUri,
            method: 'POST',
            dataType: 'json',
            async: false,
            data: {
                action: 'RESEND_EMAIL',
                uID: ''
            },
            beforeSend: function (){
                btn.prop('disabled', true);
            },
            success: function (response) {
                if (response.status === "success") {
                    $('.button-progress').delay(1000).queue(function () {
                        $(this).css('width', '100%')
                    });
                    setTimeout(function(){
                        btn.prop('disabled', false);
                    }, fewSeconds*1000);

                    $.jnoty("Email was successfully resent.", {
                        header: 'Success',
                        sticky: false,
                        theme: 'jnoty-success',
                        icon: 'fa fa-check-circle'
                    });
                }else if(response.status === "active"){
                    window.location = '/login/';
                }else{
                    btn.prop('disabled', false);
                    $.jnoty("Email could not be sent at this time.", {
                        header: 'Failed',
                        sticky: false,
                        theme: 'jnoty-danger',
                        icon: 'fa fa-check-circle'
                    });
                }
            }
        });
    });
});