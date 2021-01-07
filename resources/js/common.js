$(document).ready(function(){
    if($.isFunction($.fn.select2)){
        $(".select2")
        .select2({
        templateResult: countryFlag,
        templateSelection: countryFlag,
        placeholder: function () {
            $(this).data("placeholder").trigger("change");
        },
        })
        .on("select2:close", function (e) {
        $(this).valid();
        });

    $(".select2noimg")
        .select2({
        placeholder: function () {
            $(this).data("placeholder").trigger("change");
        },
        })
        .on("select2:close", function (e) {
        $(this).valid();
        });

        $(".select2noimgsearch")
        .select2({
            minimumResultsForSearch: -1,
            placeholder: function () {
                $(this).data("placeholder").trigger("change");
            },
        });
    }

    
    $('.logout').click(function(){
        swal({
            title: "End Session",
            text: "Are you sure you want sing out?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn btn-danger",
            confirmButtonText: "I'm sure",
            closeOnConfirm: false
        },
        function(){
            $.ajax({
                url: baseUri,
                method: 'POST',
                dataType: 'json',
                async: false,
                data: {
                    action: 'LOGOUT',
                },
                success: function (response) {
                    window.location = '/login/';
                }
            });
        });
        
    });

    //Increment Time
    $("body").bind('onclick onkeypress scroll', function(e) {
        $.ajax({
            url: baseUri,
            method: 'POST',
            dataType: 'json',
            async: false,
            data: {
                action: 'SESSION_ADD_TIME',
            },
            success: function (response) {}
        });
    });

    //Check Session 
    setInterval(function(){ 
        $.ajax({
            url: baseUri,
            method: 'POST',
            dataType: 'json',
            async: false,
            data: {
                action: 'CHECK_SESSION',
            },
            success: function (response) {
                if(response.status == "success"){
                    window.location = '/login/';
                }
            }
        });
     }, 600000);


});

function countryFlag (opt) {
    if (!opt.id) { return opt.text; }
    var optimage = $(opt.element).data('image');
    return $('<span><img src="' + optimage + '" class="img-flag" /> ' + $(opt.element).text() + '</span>');
  }

  function checkPassword(passwordVal){
    var $res = false;
    $.ajax({
        url: baseUri,
        method: 'POST',
        dataType: 'json',
        async: false,
        data: {
            action: 'CHECK_PASSWORD',
            password: passwordVal
        },
        success: function (response) {
            $res = (response.status == "success") ? true : false;
        }
    });

    return $res;
  }

function copyToClipboard(elem) {
    // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
      // can just use the original source element for the selection and copy
      target = elem;
      origSelectionStart = elem.selectionStart;
      origSelectionEnd = elem.selectionEnd;
    } else {
      // must use a temporary form element for the selection and copy
      target = document.getElementById(targetId);
      if (!target) {
          var target = document.createElement("textarea");
          target.style.position = "absolute";
          target.style.left = "-9999px";
          target.style.top = "0";
          target.id = targetId;
          document.body.appendChild(target);
      }
      target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);
  
    // copy the selection
    var succeed;
    try {
        succeed = document.execCommand("copy");
    } catch(e) {
      succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
      currentFocus.focus();
    }
  
    if (isInput) {
      // restore prior selection
      elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
      // clear temporary content
      target.textContent = "";
    }
    return succeed;
}
