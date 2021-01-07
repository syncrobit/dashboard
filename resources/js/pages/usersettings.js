$(document).ready(function(){
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
            time_format: $('input[name="time_format"]:checked').val()
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

/* Add Wallet Address */
    var $addW_form = $('#add_wallet_form');
    $addW_form.validate({
        rules: {
        w_nickname: {
            required: true
        },
        w_addr: {
                required: true,
                remote: {
                url: baseUri,
                type: 'POST',
                async: false,
                    data: {
                    action: 'CHECK_HELIUM_ADDRESS',
                    w_address: function() {
                        return $("#w_addr").val();
                    }
                },
            },
        }
    },
    showErrors: formErrorDisplay,
    submitHandler: function (ev) {
        $addW_form.validate();
      if($addW_form.valid()){
        $.ajax({
            url: baseUri,
            method: 'POST',
            dataType: 'json',
            async: false,
            data: {
                action: 'ADD_WALLET_ADDRESS',
                nickname: $('#w_nickname').val(),
                wAddr: $("#w_addr").val()
            },
            beforeSend: function (){
                $('.btn-add-wallet').prop('disabled', true);
            },
            success: function (response) {
              $('.btn-add-wallet').prop('disabled', false);

              if (response.status === "success") {
                $('#add-wallet-modal').modal('hide');

                $('.wallets-table').find('.no_wallets').remove();
                $('.wallets-table').append(
                    '<tr data-id="'+ response.walletID +'">' +
                    '<th scope="row">' + response.walletNickname + '</th>' +
                    '<td class="align-middle">' + response.walletBalance + ' HNT</td>' +
                    '<td class="text-center align-middle">' +
                    '<a href="javascript:void(0);" class="btn btn-sm btn-primary edit-wallet mr-2" title="Edit">' +
                    '<i class="fas fa-edit"></i>' +
                    '</a>' +
                    '<a href="javascript:void(0);" class="btn btn-sm btn-danger delete-wallet" title="Delete">' +
                    '<i class="fas fa-trash"></i>' + 
                    '</a>' +
                    '</td>' +
                    '</tr>'
                    );

                $.jnoty("Wallet added successfully.", {
                  header: 'Success',
                  sticky: false,
                  theme: 'jnoty-success',
                  icon: 'fa fa-check-circle'
                });
              }else if(response.status === "address_invalid"){
                $.jnoty("Wallet address seems to be invalid!", {
                    header: 'Failed',
                    sticky: false,
                    theme: 'jnoty-danger',
                    icon: 'fa fa-check-circle'
                });
              }else{
                $.jnoty("Wallet cannot be added, try again later", {
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

    $('#add-wallet-modal').on('hidden.bs.modal', function () {
        $addW_form.find('input').val('')
            .removeClass("parsley-error")
            .data("title", "")
            .tooltip("dispose");
    });

    /* End Add Wallet */

    /* Edit Wallet Details */
    $('.wallets-table').on('click', '.edit-wallet', function(){
        var $wID = $(this).parent().parent().data('id');
        
        $.ajax({
            url: baseUri,
            method: 'POST',
            dataType: 'json',
            async: false,
            data: {
                action: 'GET_USER_WALLET_DETAILS',
                wID: $wID
            },
            success: function (response) {
              if (response.status === "success") {
                $('.ew_nickname').val(response.wallet.nickname);
                $('.ew_addr').val(response.wallet.w_address);
                $('.ew_id').val($wID);
                $('#edit-wallet-modal').modal('show');
              }else{
                $.jnoty("Cannot get wallet details, try again later", {
                  header: 'Failed',
                  sticky: false,
                  theme: 'jnoty-danger',
                  icon: 'fa fa-check-circle'
                });
              }
            }
        });
    });

    var $editW_form = $('#edit_wallet_form');
    $editW_form.validate({
        rules: {
        ew_nickname: {
          required: true
        },
        ew_addr: {
          required: true,
          remote: {
          url: baseUri,
          type: 'POST',
          async: false,
            data: {
              action: 'CHECK_HELIUM_ADDRESS',
              w_address: function() {
                  return $("#ew_addr").val();
              }
            },
          },
        }
    },
    showErrors: formErrorDisplay,
    submitHandler: function (ev) {
        $editW_form.validate();
      if($editW_form.valid()){
        var $wID = $('#ew_id').val();
        var $nickName = $('#ew_nickname').val();
        $.ajax({
            url: baseUri,
            method: 'POST',
            dataType: 'json',
            async: false,
            data: {
                action: 'EDIT_USER_WALLET',
                wID: $wID,
                nickname: $nickName,
                wAddr: $("#ew_addr").val(),
            },
            beforeSend: function (){
              $('.btn-edit-wallet').prop('disabled', true);
            },
            success: function (response) {
              $('.btn-edit-wallet').prop('disabled', false);

              if (response.status === "success") {
                $('#edit-wallet-modal').modal('hide');
                var $row = $('.wallets-table').find('tr[data-id="' + $wID + '"]');
                $row.find('th').html($nickName);

                $.jnoty("Wallet updated successfully.", {
                  header: 'Success',
                  sticky: false,
                  theme: 'jnoty-success',
                  icon: 'fa fa-check-circle'
                });
              }else if(response.status === "address_invalid"){
                $.jnoty("Wallet address seems to be invalid!", {
                    header: 'Failed',
                    sticky: false,
                    theme: 'jnoty-danger',
                    icon: 'fa fa-check-circle'
                });
              }else{
                $.jnoty("Wallet cannot be updated, try again later", {
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

    $('#edit-wallet-modal').on('hidden.bs.modal', function () {
        $editW_form.find('input').val('')
            .removeClass("parsley-error")
            .data("title", "")
            .tooltip("dispose");
    });

    /* End Edit Wallet Address */

    /* Delete Wallet Address */
    $('.wallets-table').on('click', '.delete-wallet', function(){
        var $parent =  $(this).parent().parent();
        
        swal({
            title: "Remove Wallet",
            text: "Are you sure you want remove this wallet?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn btn-danger",
            confirmButtonText: "I'm sure",
            closeOnConfirm: true,
          },
          function () {
            $.ajax({
              url: baseUri,
              method: "POST",
              dataType: "json",
              async: false,
              data: {
                action: "DELETE_USER_WALLET",
                wID: $parent.data("id"),
              },
              success: function (response) {
                if (response.status == "success") {
                  $parent.remove();
                  if(response.count === 0){
                    $('.wallets-table').append(
                        '<tr class="no_wallets">'+ 
                        '<th scope="row" colspan="3" class="text-center">You have no wallets. Add a wallet to track</th>' +
                        '</tr>'
                    );
                  }  
                
                  $.jnoty("Wallet successfully removed.", {
                    header: "Success",
                    sticky: false,
                    theme: "jnoty-success",
                    icon: "fa fa-check-circle",
                  });
            
                } else {
                  $.jnoty("Wallet cannot be removed, try again later", {
                    header: "Failed",
                    sticky: false,
                    theme: "jnoty-danger",
                    icon: "fa fa-check-circle",
                  });
                }
              },
            });
        });
    });
    /* End Delete Wallet Address */

    /* Generate New API Key */
    $('.add-apiKey').click(function(){
      $.ajax({
        url: baseUri,
        method: "POST",
        dataType: "json",
        async: false,
        data: {
          action: "GENERATE_NEW_KEY"
        },
        success: function (response) {
          if (response.status == "success") {
              $('#api_key_input').val(response.apiKey);
              $('#add-apiKey-modal').modal('show'); 
          } else {
            $.jnoty("API key cannot be generated, try again later", {
                header: "Failed",
                sticky: false,
                theme: "jnoty-danger",
                icon: "fa fa-check-circle",
            });
          }
        },
      });

  });

  /* End Generate Key */

  /* Copy Key From Modal */
  $('.copy-key-modal').click(function(){
    var $elem = document.getElementById("api_key_input");
    var $succeed = copyToClipboard($elem);
    var $btn = $(this).find('span.input-group-btn');

    if (!$succeed) {
      $btn.html('<i class="fas fa-times text-danger"></i>');
    } else {
      $btn.html('<i class="fas fa-check text-success"></i>');
    }

    setTimeout(function(){ $btn.html('<i class="fas fa-copy"></i>'); }, 2000);
  });
  /* End Copy Key From Modal */


    /* Upgrade Modal */
    $('.upgrade-mod').click(function(){
      $('#upgrade-pgk-modal').modal('show');
    });
    /* End Upgrade Modal */

    /* Add API Key */
    var $addKey_form = $('#add_key_form');
    $addKey_form.validate({
        rules: {
          a_app_name: {
          required: true
        }
    },
    showErrors: formErrorDisplay,
    submitHandler: function (ev) {
      $addKey_form.validate();
      if($addKey_form.valid()){
        $.ajax({
            url: baseUri,
            method: 'POST',
            dataType: 'json',
            async: false,
            data: {
                action: 'ADD_API_KEY',
                appName: $('#a_app_name').val(),
            },
            beforeSend: function (){
              $('.btn-add-key').prop('disabled', true);
            },
            success: function (response) {
              $('.btn-add-key').prop('disabled', false);

              if (response.status === "success") {
                $('#add-apiKey-modal').modal('hide');
                $('.no-apiKeys').remove();

                $('.api-keys-table').append(
                  '<tr data-id="'+ response.id +'">' +
                  '<th scope="row">'+ response.appName +'</th>' +
                  '<td class="align-middle">'+ response.createdOn +'</td>' +
                  '<td class="text-center align-middle">' +
                  '<a href="javascript:void(0);" class="btn btn-sm btn-primary view-akey mr-2" title="View">' +
                  '<i class="fas fa-eye"></i>' +
                  '</a>' +
                  '<a href="javascript:void(0);" class="btn btn-sm btn-danger delete-akey" title="Delete">' +
                  '<i class="fas fa-trash"></i>' +
                  '</a>' +
                  '</td>' +
                  '</tr>'
                );

                $.jnoty("API Key successfully added.", {
                  header: 'Success',
                  sticky: false,
                  theme: 'jnoty-success',
                  icon: 'fa fa-check-circle'
                });
              }else{
                $.jnoty("API Key cannot be added, try again later", {
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

  $('#add-apiKey-modal').on('hidden.bs.modal', function () {
    $addKey_form.find('input').val('')
        .removeClass("parsley-error")
        .data("title", "")
        .tooltip("dispose");
  });
  /* End Add API Key */

  /* Delete API Key */
  $('.api-keys-table').on('click', '.delete-akey', function(){
    var $parent =  $(this).parent().parent();
        
    swal({
        title: "Remove API Key",
        text: "Are you sure you want remove this API Key?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn btn-danger",
        confirmButtonText: "I'm sure",
        closeOnConfirm: true,
      },
      function () {
        $.ajax({
          url: baseUri,
          method: "POST",
          dataType: "json",
          async: false,
          data: {
            action: "DELETE_KEY",
            kID: $parent.data("id"),
          },
          success: function (response) {
            
            if (response.status == "success") {
              $parent.remove();
              if(response.count === 0){
                $('.api-keys-table').append(
                  '<tr class="no-apiKeys">'+ 
                  '<th scope="row" colspan="3" class="text-center">You have no API keys. Add a key...</th>' +
                  '</tr>'
                );
              }  
            
              $.jnoty("API Key successfully removed.", {
                header: "Success",
                sticky: false,
                theme: "jnoty-success",
                icon: "fa fa-check-circle",
              });
        
            } else {
              $.jnoty("API Key cannot be removed, try again later", {
                header: "Failed",
                sticky: false,
                theme: "jnoty-danger",
                icon: "fa fa-check-circle",
              });
            }
          },
        });
      });
  });
  /* End Delete Key */

  /* Start Get Api Key */
  $('.api-keys-table').on('click', '.view-akey', function(){
    var $parent =  $(this).parent().parent();

    $.ajax({
      url: baseUri,
      method: "POST",
      dataType: "json",
      async: false,
      data: {
        action: "GET_API_KEY",
        kID: $parent.data("id"),
      },
      success: function (response) {
        if(response.status == "success"){
          swal({
            title: "View API Key",
            html: true,
            text: '<div class="input-group mt-3">' + 
            '<input class="form-control disabled api_vkey_input" id="api_vkey_input" placeholder="API Key" type="text" readonly="readonly">' + 
            '<span class="input-group-btn">' +
            '<button class="btn btn-primary copy-key-view" type="button">' +
            '<span class="input-group-btn"><i class="fas fa-copy"></i></span>' +
            '</button>' +
            '</span>' + 
            '</div>',
            showCancelButton: false,
            confirmButtonText: "Got it!",
            closeOnConfirm: true
          });

          $('.api_vkey_input').val(response.apiKey);
          $('.copy-key-view').click(function(){
            var $elem = document.getElementById("api_vkey_input");
            var $succeed = copyToClipboard($elem);
            var $btn = $(this).find('span.input-group-btn');
        
            if (!$succeed) {
              $btn.html('<i class="fas fa-times text-danger"></i>');
            } else {
              $btn.html('<i class="fas fa-check text-success"></i>');
            }
        
            setTimeout(function(){ $btn.html('<i class="fas fa-copy"></i>'); }, 2000);
          });
        }else{
          $.jnoty("Cannot get API key, try again later", {
            header: "Failed",
            sticky: false,
            theme: "jnoty-danger",
            icon: "fa fa-check-circle",
          });
        }
      }
    });  
  });
  /* End Get Api Key */
  
  /* Change Billing Interval */
  $('#billing_filter').on("select2:selecting", function(e) { 
    var $val = $(this).val();

    $.ajax({
      url: baseUri,
      method: "POST",
      dataType: "json",
      data: {
        action: "GET_HISTORY",
        range: $val,
      },
      beforeSend: function(){
        $('.history-wrapper').html(
          '<div class="text-center pd-10">' +
          '<i class="fas fa-spinner fa-spin"></i> '
          + 'Loading results...' +
          '</div>');
      },
      success: function (response) {
        if(response.status == "success"){
          $('.history-wrapper').html(response.history);
        }else{
          $.jnoty("Cannot refresh history, try again later", {
            header: "Failed",
            sticky: false,
            theme: "jnoty-danger",
            icon: "fa fa-check-circle",
          });
        }
      }
    }); 
  });


  $('.select-plan').click(function(){
    swal({
      title: "Change Plan",
      text: "Plan change will come in effect immediately. \r\n Note: If you are downgrading from your current plan hotspots above the limit will be removed.",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn btn-danger",
      confirmButtonText: "Yes, change it!",
      closeOnConfirm: true,
    },
    function () {

    });
  })
})