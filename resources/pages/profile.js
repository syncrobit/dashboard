$(document).ready(function(){
    
    $('.select2').select2({
        templateResult: countryFlag,
        templateSelection: countryFlag,
        placeholder: function() {
            $(this).data('placeholder');
        }
    }).on("select2:close", function (e) {
        $(this).valid();
    });

    $('.select2noimg').select2({
      placeholder: function () {
          $(this).data('placeholder').trigger('change');
      },
    }).on("select2:close", function (e) {
      $(this).valid();
    });

    $('#new_pass').passtrength({
      minChars: 8,
      passwordToggle: false,
      tooltip: false
    });

    $(document).on("mouseenter", 'input[name="uploadimg"]', function() {
      $('.profile-hover').fadeIn();
    }).on("mouseleave", 'input[name="uploadimg"]', function() {
      $('.profile-hover').fadeOut();
    });
  
    /* Get User Details */
    $.ajax({
      url: baseUri,
      method: 'POST',
      dataType: 'json',
      data: {
          action: 'GET_USER_DETAILS'
      },
      success: function (response) {
          if (response.status === "success") {
              $('.first_name').val(response.data.first_name);
              $('.last_name').val(response.data.last_name);
              $('.email').val(response.data.email);
              $('.country').val(response.data.country).trigger('change');
              if(response.data.zip_code.length > 0){
                $('.zip_code').val(response.data.zip_code).prop('disabled', false);
              }
              if(response.data.address.length > 0){
                $('.address').val(response.data.address).prop('disabled', false);
              }
              if(response.data.city.length > 0){
                $('.city').val(response.data.city).prop('disabled', false);
              }
              $('.state').val(response.data.state).trigger('change');
            }
      }
    });
  /* End Get User Details */

  $('.country').on("select2:selecting", function(e) { 
    $('.zip_code').val('').prop('disabled', false);
    $('.city').val('');
  }).on("change", function(){
    $.ajax({
      url: baseUri,
      method: 'POST',
      dataType: 'json',
      async: false,
      data: {
        action: 'GET_STATES',
        iso: $('.country').val()
      },
      success: function (response) {
        if (response.status === "success") {
          $('.state').empty().select2({
              data: response.data,
              placeholder: function () {
                $('.state').data('placeholder').trigger('change');
            },
          });
        }
      }
    });
  });


  $('.zip_code').on('keyup', function() {
    var zipCode = $(this);
    
    if(zipCode.val().length === 0 ) {
      $('.city').val('').prop('disabled', true);
      $('.state').val('').prop('disabled', true).trigger('change')

      return;
    }

    $.ajax({
        url: baseUri,
        method: 'POST',
        dataType: 'json',
        data: {
            action: 'GET_CITY_STATE',
            iso: $('.country').val(),
            zipCode: zipCode.val()
        },
        success: function (response) {
            if (response.status === "success") {
                $('.address').prop('disabled', false);
                $('.city').prop('disabled', false).val(response.data.city);
                $('.state').prop('disabled', false).val(response.data.state).trigger('change');
            }
        }
      });
    });

    /* Update User Details */
    $('#user_details_form').validate({
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
                      action: 'CHECK_EMAIL_EXCEPTION',
                      email: function() {
                          return $("#email").val();
                      }
                  },
              }
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
                  action: 'UPDATE_USER_DETAILS',
                  first_name: $('#first_name').val(),
                  last_name: $('#last_name').val(),
                  email: $('#email').val(),
                  address: $('#address').val(),
                  city: $('#city').val(),
                  state: $('#state').val(),
                  country: $('#country').val(),
                  zip: $('#zip_code').val()
              },
              beforeSend: function (){
                  $('.btn-details-change').prop('disabled', true);
                  $('.button-label').hide();
                  $('.button-spinner').show();
              },
              success: function (response) {
                $('.button-label').show();
                $('.button-spinner').hide();
                $('.btn-details-change').prop('disabled', false);

                if (response.status === "success") {
                  $.jnoty("Changes successfully saved.", {
                    header: 'Success',
                    sticky: false,
                    theme: 'jnoty-success',
                    icon: 'fa fa-check-circle'
                  });
                }else if(response.status === "email_exits"){
                  $('.email').tooltip("dispose") // Destroy any pre-existing tooltip so we can repopulate with new tooltip content
                      .data("title", 'Email already exists!')
                      .addClass("parsley-error")
                      .tooltip({placement : 'right'}); // Create a new tooltip based on the error message we just set in the title
                }else{
                  $.jnoty("Action cannot be performed, try again later", {
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

  /* End Update User Details */

  /* Update User Password */
  $('#password_change_form').validate({
    rules: {
      current_pass: {
            required: true,
            remote: {
              url: baseUri,
              type: 'POST',
              async: false,
                 data: {
                  action: 'CHECK_CURRENT_PASSWORD',
                  password: function() {
                      return $("#current_pass").val();
                  }
              },
          },
        },
        new_pass: {
            required: true,
            minlength: 8
        },
        renew_pass:{
            required: true, 
            equalTo: '#new_pass'   
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
                action: 'UPDATE_PASSWORD',
                password: $('#new_pass').val(),
                current_pass: $("#current_pass").val()
            },
            beforeSend: function (){
                $('.btn-pass-change').prop('disabled', true);
                $('.button-label').hide();
                $('.button-spinner').show();
            },
            success: function (response) {
              $('.button-label').show();
              $('.button-spinner').hide();
              $('.btn-pass-change').prop('disabled', false);

              if (response.status === "success") {
                $.jnoty("Password successfully changed. You will be redirected in 5 seconds.", {
                  header: 'Success',
                  sticky: false,
                  theme: 'jnoty-success',
                  icon: 'fa fa-check-circle'
                });
                $('body').append('<meta http-equiv="refresh" content="5; URL=/login/" />');
              }else if(response.status === "pass_not_match"){
                $('.current_pass').tooltip("dispose") // Destroy any pre-existing tooltip so we can repopulate with new tooltip content
                    .data("title", 'Current Password does not match!')
                    .addClass("parsley-error")
                    .tooltip({placement : 'right'}); // Create a new tooltip based on the error message we just set in the title
              }else{
                $.jnoty("Action cannot be performed, try again later", {
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
  /* End Update user password */

  /*Upload Profile image */
    var uploader = new ss.SimpleUpload({
        button: 'change-p-image', // file upload button
        url: 'uploadHandler.php', // server side handler
        name: 'uploadimg', // upload parameter name        
        responseType: 'json',
        allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
        maxSize: 1024, // kilobytes
        hoverClass: 'ui-state-hover',
        onSubmit: function(filename, extension) {
            this.setFileSizeBox(sizeBox); // designate this element as file size container
            this.setProgressBar(progress); // designate as progress bar
          },         
        onComplete: function(filename, response) {
            if (!response) {
                alert(filename + 'upload failed');
                return false;            
            }
            // do something with response...
          }
    }); 
    
    /* End Upload Profile Image */
  

});