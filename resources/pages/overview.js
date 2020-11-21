$(document).ready(function(){
    $.ajax({
        url: baseUri,
        method: 'POST',
        dataType: 'json',
        data: {
            action: 'GET_OVERVIEW',
        },
        beforeSend: function (){
            
        },
        success: function (response) {
            if (response.status === "success") {
                $('.block_height').html('<h2 class="m-t-0 m-b-15"><b>'+ response.data.block_height + '</b></h2>' +
                    '<p class="text-muted m-b-0 m-t-20">Block time: <b>'+ response.data.block_time + 's</b> </p>');
                
                $('.total_earnings').html('<h2 class="m-t-0 m-b-15">' +
                    '<i class="mdi mdi-arrow-up text-success m-r-10"></i>' +
                    '<b>'+ response.data.balance +' HNT</b>' +
                    '</h2>' +
                    '<p class="text-muted m-b-0 m-t-20"><b>'+ response.data.balance_trend +'%</b> from last week</p>');

                $('.hnt_price').html('<h2 class="m-t-0 m-b-15">' +
                '<i class="mdi '+ response.data.price_history.icon +' m-r-10"></i>' +
                '<b>$' + response.data.price_history.current + '</b>' +
                '</h2>' +
                '<p class="text-muted m-b-0 m-t-20">' +
                '<b>' + response.data.price_history.percentage +'%</b> from last oracle update</p>');    
            }else{
                $.jnoty("Data could not be fetched...", {
                    header: 'Failed',
                    sticky: false,
                    theme: 'jnoty-danger',
                    icon: 'fa fa-check-circle'
                });
            }
        }
    });
});