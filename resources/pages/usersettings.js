$(document).ready(function(){
    $('.select2noimg').select2({
        placeholder: function () {
            $(this).data('placeholder').trigger('change');
        },
    }).on("select2:close", function (e) {
        $(this).valid();
    });

    /* Get User Settings */
    $.ajax({
        url: baseUri,
        method: 'POST',
        dataType: 'json',
        data: {
            action: 'GET_USER_SETTINGS'
        },
        success: function (response) {
            if (response.status === "success") {
                $('.wallet-address').val(response.data.wallet_address);
                $('.time_zone').val(response.data.time_zone).trigger('change');
                $('input[name="date_format"][value="'+ response.data.date_format + '"]').prop('checked', true);
                $('input[name="time_format"][value="'+ response.data.time_format + '"]').prop('checked', true);
            }
        }
    });
    /* End Get User Settings */
    
    /* Update User Settings */
    $('.submit-settings').click(function(e){
        var btn = $(this);
        e.preventDefault();
        $.ajax({
            url: baseUri,
            method: 'POST',
            dataType: 'json',
            data: {
                action: 'UPDATE_USER_SETTINGS',
                time_zone: $('.time_zone').val(),
                date_format: $('input[name="date_format"]:checked').val(),
                time_format: $('input[name="time_format"]:checked').val(),
                wallet_address: $('.wallet-address').val()

            },
            beforeSend: function (){
                btn.prop('disabled', true);
                $('.button-label').hide();
                $('.button-spinner').show();
            },
            success: function (response) {
                btn.prop('disabled', false);
                $('.button-label').show();
                $('.button-spinner').hide();

                if (response.status === "success") {
                    $.jnoty("Changes successfully saved.", {
                        header: 'Success',
                        sticky: false,
                        theme: 'jnoty-success',
                        icon: 'fa fa-check-circle'
                    });
                }else{
                    $.jnoty("Cannot save changes.", {
                        header: 'Failed',
                        sticky: false,
                        theme: 'jnoty-danger',
                        icon: 'fa fa-check-circle'
                    });
                }
            }
        });
    });
    /* End Update User Settings */

})