$(document).ready(function(){
    var start = moment().subtract(7, 'days');
    var end = moment();

    function cb(start, end) {
        $('.fc-datepicker').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('.fc-datepicker').daterangepicker({
        startDate: start,
        endDate: end,
        maxDate: moment(),
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
         }
    }).on('apply.daterangepicker', function(ev, picker) {
        $.ajax({
            url: baseUri,
            method: "POST",
            dataType: "json",
            async: false,
            data: {
              action: "GET_ACCT_HISTORY",
              start: picker.startDate.format('YYYY-MM-DD'),
              end: picker.endDate.format('YYYY-MM-DD')
            },
            beforeSend: function(){
                $('.history-wrapper').html(
                  '<div class="text-center pd-10">' +
                  '<i class="fas fa-spinner fa-spin"></i> '
                  + 'Loading results...' +
                  '</div>');
              },
            success: function (response) {
                $('.history-wrapper').html(response.history);
            }
          });
    });
    
    $('.history-wrapper').on('click', '.show-ip-details', function(){
        var $ip = $(this).data('ip');

        $.ajax({
            url: baseUri,
            method: "POST",
            dataType: "json",
            async: false,
            data: {
              action: "CREATE_IP_MAP",
              ip: $ip,
            },
            success: function (response) {
              $('.map-script').html(response.map);
              $('.ip-city').html(response.city);
              $('.ip-state').html(response.state);
              $('.ip-country').html(response.country);
              $('#view-ip-modal').modal('show');
            }
          });
    });

    $('#view-ip-modal').on('shown.bs.modal', function() {
        map.resize();
    });

    $('.history-wrapper').on('click', '.report', function(){
        var $id = $(this).data('id');

        swal({
          title: "Report", 
          text: "If you do not recognize the IP address or you have not performed the action," + 
          " please let us know and we will investigate further." +
          "<textarea id='reason' placeholder='Please secifiy reason'></textarea>",
          html: true,
          showCancelButton: true,
          confirmButtonText: "Submit",
          closeOnConfirm: true
        }, function() {
            console.log('test');
        });

    });
})