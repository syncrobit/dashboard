$(document).ready(function () {
  
  $("#new_pass").passtrength({
    minChars: 8,
    passwordToggle: false,
    tooltip: false,
  });

  /* Get User Details */
  $.ajax({
    url: baseUri,
    method: "POST",
    dataType: "json",
    data: {
      action: "GET_USER_DETAILS",
    },
    success: function (response) {
      if (response.status === "success") {
        $(".first_name").val(response.data.first_name);
        $(".last_name").val(response.data.last_name);
        $(".email").val(response.data.email);
        $(".country").val(response.data.country).trigger("change");
        if (response.data.zip_code != null || response.data.zip_code != "") {
          $(".zip_code").val(response.data.zip_code).prop("disabled", false);
        }
        if (response.data.address != null || response.data.address != "") {
          $(".address").val(response.data.address).prop("disabled", false);
        }
        if (response.data.city != null || response.data.city != "") {
          $(".city").val(response.data.city).prop("disabled", false);
        }
        $(".state").val(response.data.state).trigger("change");
      }
    },
  });
  /* End Get User Details */

  $(".country")
    .on("select2:selecting", function (e) {
      $(".zip_code").val("").prop("disabled", false);
      $(".city").val("");
    })
    .on("change", function () {
      $.ajax({
        url: baseUri,
        method: "POST",
        dataType: "json",
        async: false,
        data: {
          action: "GET_STATES",
          iso: $(".country").val(),
        },
        success: function (response) {
          if (response.status === "success") {
            $(".state")
              .empty()
              .select2({
                data: response.data,
                placeholder: function () {
                  $(".state").data("placeholder").trigger("change");
                },
              });
          }
        },
      });
    });

  $(".zip_code").on("keyup", function () {
    var zipCode = $(this);

    if (zipCode.val().length === 0) {
      $(".city").val("").prop("disabled", true);
      $(".state").val("").prop("disabled", true).trigger("change");
      return;
    }

    $.ajax({
      url: baseUri,
      method: "POST",
      dataType: "json",
      data: {
        action: "GET_CITY_STATE",
        iso: $(".country").val(),
        zipCode: zipCode.val(),
      },
      success: function (response) {
        if (response.status === "success") {
          $(".address").prop("disabled", false);
          $(".city").prop("disabled", false).val(response.data.city);
          $(".state")
            .prop("disabled", false)
            .val(response.data.state)
            .trigger("change");
        }
      },
    });
  });

  /* Update User Details */
  var $user_from = $('#user_details_form')
  $user_from.validate({
    ignore: [],
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
    showErrors: formErrorDisplay,
    submitHandler: function (ev) {
      $user_from.validate();
      if($user_from.valid()){

        swal({
          title: "Confirm changes", 
          text: "Please type your account password to confirm changes", 
          type: "input",
          inputType: "password",
          inputPlaceholder: "Password",
          showCancelButton: true,
          closeOnConfirm: false
        }, function(passwordVal) {

          if (passwordVal === "") {
            swal.showInputError("Filed is required");
            return false
          }
      
          if(checkPassword(passwordVal)){
            $.ajax({
              url: baseUri,
              method: 'POST',
              dataType: 'json',
              async: false,
              data: {
                  action: 'UPDATE_USER_DETAILS',
                  first_name: $('#first_name').val(),
                  last_name: $('#last_name').val(),
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
                swal.close();
                
                if (response.status === "success") {
                  $.jnoty("Changes successfully saved.", {
                    header: 'Success',
                    sticky: false,
                    theme: 'jnoty-success',
                    icon: 'fa fa-check-circle'
                  });
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
          }else{
            swal.showInputError("Password did not match!");
            return false
          }
        });
      }
    }
  });

  /* Update User Email */

    var $email_form = $('#user_email_form');
    $email_form.validate({
      ignore: [],
      rules: {
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
          }
      },
      showErrors: formErrorDisplay,
      submitHandler: function (ev) {
        $email_form.validate();
        if($email_form.valid()){
          swal({
            title: "Confirm changes", 
            text: "Please type your account password to confirm changes. A verification email will be sent to the new address.", 
            type: "input",
            inputType: "password",
            inputPlaceholder: "Password",
            showCancelButton: true,
            closeOnConfirm: false
          }, function(passwordVal) {
  
            if (passwordVal === "") {
              swal.showInputError("Filed is required");
              return false
            }
        
            if(checkPassword(passwordVal)){
              $.ajax({
                url: baseUri,
                method: 'POST',
                dataType: 'json',
                async: false,
                data: {
                    action: 'CHANGE_EMAIL',
                    email: $('#email').val(),
                },
                beforeSend: function (){
                    $('.btn-email-change').prop('disabled', true);
                    $('.button-label').hide();
                    $('.button-spinner').show();
                },
                success: function (response) {
                  $('.button-label').show();
                  $('.button-spinner').hide();
                  $('.btn-email-change').prop('disabled', false);
                  swal.close();
                  
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
            }else{
              swal.showInputError("Password did not match!");
              return false
            }
          });
        }
      }
    });

  /* End Update User Email */

  /* Update User Password */
  var $pwd_form = $('#password_change_form');
  $pwd_form.validate({
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
    showErrors: formErrorDisplay,
    submitHandler: function (ev) {
      $pwd_form.validate();
      if($pwd_form.valid()){
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
    }

  });
  /* End Update user password */

  /*Upload Profile image */
  var progressBar = $(".progress-bar"),
    progressOuter = $(".progress"),
    profileModal = $("#profile-img-modal");

  var uploader = new ss.SimpleUpload({
    button: "profile-edit", // file upload button
    url: "/uploadHandler.php", // server side handler
    name: "uploadimg", // upload parameter name
    responseType: "json",
    allowedExtensions: ["jpg", "jpeg", "png", "gif"],
    maxSize: 2048, // kilobytes
    hoverClass: "ui-state-hover",
    startXHR: function () {
      $(".profilePicBox").croppie("destroy");
      profileModal.modal("show");
    },
    onSubmit: function (filename, extension) {
      progressOuter.show(); // designate this element as file size container
      this.setProgressBar(progressBar); // designate as progress bar
    },
    onComplete: function (filename, response) {
      if (!response) {
        profileModal.modal("hide");
        $.jnoty("Upload failed, please try again later", {
          header: "Failed",
          sticky: false,
          theme: "jnoty-danger",
          icon: "fa fa-check-circle",
        });
        return false;
      }

      if (response.success === true) {
        progressOuter.hide();
        var basic = $(".profilePicBox").croppie({
          viewport: {
            width: 250,
            height: 250,
          },
          enableOrientation: true,
          enableExif: true,
        });

        basic.croppie("bind", {
          url: response.file,
        });

        $(".cr-slider-wrap").append(
          '<div style="float:right;">' +  
          '<button type="button" class="btn waves-effect btn-primary btn-rotate" data-deg="-90" style="margin-right: 5px;">' +
            '<i class="mdi mdi mdi-rotate-right"></i> </button>' +
            '<button type="button" class="btn waves-effect btn-primary btn-rotate" data-deg="90">' +
            '<i class="mdi mdi mdi-rotate-left"></i> </button>' +
            '</div>'
        );

        $(".btn-rotate").on("click", function (ev) {
          basic.croppie("rotate", parseInt($(this).data("deg")));
        });

        $(".save-img").click(function () {
          var btn_save = $(this);
          basic.croppie("result", "blob").then(function (blob) {
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function () {
              var base64data = reader.result;

              $.ajax({
                url: baseUri,
                method: "POST",
                dataType: "json",
                async: false,
                data: {
                  action: "UPDATE_PROFILE_IMG",
                  img: base64data,
                },
                beforeSend: function () {
                  btn_save.prop("disabled", true);
                  $(".button-label").hide();
                  $(".button-spinner").show();
                },
                success: function (response) {
                  $(".button-label").show();
                  $(".button-spinner").hide();
                  btn_save.prop("disabled", false);

                  if (response.status === "success") {
                    $.jnoty("Profile Image successfully changed.", {
                      header: "Success",
                      sticky: false,
                      theme: "jnoty-success",
                      icon: "fa fa-check-circle",
                    });

                    $(".profile-image").attr("src", base64data);
                    profileModal.modal("hide");
                  } else {
                    $.jnoty("Action cannot be performed, try again later", {
                      header: "Failed",
                      sticky: false,
                      theme: "jnoty-danger",
                      icon: "fa fa-check-circle",
                    });
                  }
                },
              });
            };
          });
        });
      }
    },
  });
  /*End Upload Profile image */

  /*Delete Sessions */
  $('.destory-session').click(function(){
    var $parent =  $(this).parent().parent();
    
    swal({
        title: "End Session",
        text: "Are you sure you want destory this session?",
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
            action: "DESTORY_SESSION",
            sID: $parent.data("id"),
          },
          success: function (response) {
            if (response.status == "success") {
              $.jnoty("Session successfully destroyed.", {
                header: "Success",
                sticky: false,
                theme: "jnoty-success",
                icon: "fa fa-check-circle",
              });
              $parent.remove();
            } else {
              $.jnoty("Action cannot be performed, try again later", {
                header: "Failed",
                sticky: false,
                theme: "jnoty-danger",
                icon: "fa fa-check-circle",
              });
            }
          },
        });
      }
    );
  });
  /* End Delete Sessions */

  /* Delete Account */
  $('.disable-account').click(function(){
    swal({
      title: "Delete Account",
      text: "Are you sure you want delete account? This action is final and cannot be undone!",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn btn-danger",
      confirmButtonText: "I'm sure",
      closeOnConfirm: true,
    },
    function () {
      
    });

  });
  /* End Delete Account */

});
