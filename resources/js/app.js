/**
* Theme: Appzia - Bootstrap 4 Admin Template
* Author: Themesdesign
* Module/App: Main Js
*/


!function($) {
    "use strict";

    var Sidemenu = function() {
        this.$body = $("body"),
        this.$openLeftBtn = $(".open-left"),
        this.$menuItem = $("#sidebar-menu a")
    };
    Sidemenu.prototype.openLeftBar = function() {
      $("#wrapper").toggleClass("enlarged");
      $("#wrapper").addClass("forced");

      if($("#wrapper").hasClass("enlarged") && $("body").hasClass("fixed-left")) {
        $("body").removeClass("fixed-left").addClass("fixed-left-void");
      } else if(!$("#wrapper").hasClass("enlarged") && $("body").hasClass("fixed-left-void")) {
        $("body").removeClass("fixed-left-void").addClass("fixed-left");
      }

      if($("#wrapper").hasClass("enlarged")) {
        $(".left ul").removeAttr("style");
      } else {
        $(".subdrop").siblings("ul:first").show();
      }

      toggle_slimscroll(".slimscrollleft");
      $("body").trigger("resize");
    },
    //menu item click
    Sidemenu.prototype.menuItemClick = function(e) {
       if(!$("#wrapper").hasClass("enlarged")){
        if($(this).parent().hasClass("has_sub")) {
          e.preventDefault();
        }
        if(!$(this).hasClass("subdrop")) {
          // hide any open menus and remove all other classes
          $("ul",$(this).parents("ul:first")).slideUp(350);
          $("a",$(this).parents("ul:first")).removeClass("subdrop");
          $("#sidebar-menu .float-right i").removeClass("mdi-minus").addClass("mdi-plus");

          // open our new menu and add the open class
          $(this).next("ul").slideDown(350);
          $(this).addClass("subdrop");
          $(".float-right i",$(this).parents(".has_sub:last")).removeClass("mdi-plus").addClass("mdi-minus");
          $(".float-right i",$(this).siblings("ul")).removeClass("mdi-minus").addClass("mdi-plus");
        }else if($(this).hasClass("subdrop")) {
          $(this).removeClass("subdrop");
          $(this).next("ul").slideUp(350);
          $(".float-right i",$(this).parent()).removeClass("mdi-minus").addClass("mdi-plus");
        }
      }
    },

    //init sidemenu
    Sidemenu.prototype.init = function() {
      var $this  = this;
      //bind on click
      $(".open-left").click(function(e) {
        e.stopPropagation();
        $this.openLeftBar();
      });

      // LEFT SIDE MAIN NAVIGATION
      $this.$menuItem.on('click', $this.menuItemClick);

      // NAVIGATION HIGHLIGHT & OPEN PARENT
      $("#sidebar-menu ul li.has_sub a.active").parents("li:last").children("a:first").addClass("active").trigger("click");
    },

    //init Sidemenu
    $.Sidemenu = new Sidemenu, $.Sidemenu.Constructor = Sidemenu

}(window.jQuery),


function($) {
    "use strict";

    var FullScreen = function() {
        this.$body = $("body"),
        this.$fullscreenBtn = $("#btn-fullscreen")
    };

    //turn on full screen
    // Thanks to http://davidwalsh.name/fullscreen
    FullScreen.prototype.launchFullscreen  = function(element) {
      if(element.requestFullscreen) {
        element.requestFullscreen();
      } else if(element.mozRequestFullScreen) {
        element.mozRequestFullScreen();
      } else if(element.webkitRequestFullscreen) {
        element.webkitRequestFullscreen();
      } else if(element.msRequestFullscreen) {
        element.msRequestFullscreen();
      }
    },
    FullScreen.prototype.exitFullscreen = function() {
      if(document.exitFullscreen) {
        document.exitFullscreen();
      } else if(document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
      } else if(document.webkitExitFullscreen) {
        document.webkitExitFullscreen();
      }
    },
    //toggle screen
    FullScreen.prototype.toggle_fullscreen  = function() {
      var $this = this;
      var fullscreenEnabled = document.fullscreenEnabled || document.mozFullScreenEnabled || document.webkitFullscreenEnabled;
      if(fullscreenEnabled) {
        if(!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {
          $this.launchFullscreen(document.documentElement);
        } else{
          $this.exitFullscreen();
        }
      }
    },
    //init sidemenu
    FullScreen.prototype.init = function() {
      var $this  = this;
      //bind
      $this.$fullscreenBtn.on('click', function() {
        $this.toggle_fullscreen();
      });
    },
     //init FullScreen
    $.FullScreen = new FullScreen, $.FullScreen.Constructor = FullScreen

}(window.jQuery),

//portlets
function($) {
    "use strict";

    /**
    Portlet Widget
    */
    var Portlet = function() {
        this.$body = $("body"),
        this.$portletIdentifier = ".portlet",
        this.$portletCloser = '.portlet a[data-toggle="remove"]',
        this.$portletRefresher = '.portlet a[data-toggle="reload"]'
    };

    //on init
    Portlet.prototype.init = function() {
        // Panel closest
        var $this = this;
        $(document).on("click",this.$portletCloser, function (ev) {
            ev.preventDefault();
            var $portlet = $(this).closest($this.$portletIdentifier);
                var $portlet_parent = $portlet.parent();
            $portlet.remove();
            if ($portlet_parent.children().length == 0) {
                $portlet_parent.remove();
            }
        });

        // Panel Reload
        $(document).on("click",this.$portletRefresher, function (ev) {
            ev.preventDefault();
            var $portlet = $(this).closest($this.$portletIdentifier);
            // This is just a simulation, nothing is going to be reloaded
            $portlet.append('<div class="panel-disabled"><div class="loader-1"></div></div>');
            var $pd = $portlet.find('.panel-disabled');
            setTimeout(function () {
                $pd.fadeOut('fast', function () {
                    $pd.remove();
                });
            }, 500 + 300 * (Math.random() * 5));
        });
    },
    //
    $.Portlet = new Portlet, $.Portlet.Constructor = Portlet

}(window.jQuery),

//main app module
 function($) {
    "use strict";

    var AppziaApp = function() {
        this.VERSION = "1.1.0",
        this.AUTHOR = "ThemesDesign",
        this.SUPPORT = "#",
        this.pageScrollElement = "html, body",
        this.$body = $("body")
    };

    //initializing tooltip
    AppziaApp.prototype.initTooltipPlugin = function() {
        $.fn.tooltip && $('[data-toggle="tooltip"]').tooltip()
    },

    //initializing popover
    AppziaApp.prototype.initPopoverPlugin = function() {
        $.fn.popover && $('[data-toggle="popover"]').popover()
    },

    //initializing nicescroll
    AppziaApp.prototype.initNiceScrollPlugin = function() {
        //You can change the color of scroll bar here
        $.fn.niceScroll &&  $(".nicescroll").niceScroll({ cursorcolor: '#9d9ea5', cursorborderradius: '0px'});
    },

     //on doc load
    AppziaApp.prototype.onDocReady = function(e) {
      FastClick.attach(document.body);
      Menufunction.push("initscrolls");
      Menufunction.push("changeptype");

      $('.animate-number').each(function(){
        $(this).animateNumbers($(this).attr("data-value"), true, parseInt($(this).attr("data-duration")));
      });

      //RUN RESIZE ITEMS
      $(window).resize(debounce(resizeitems,100));
      $("body").trigger("resize");

      // right side-bar toggle
      //$('.right-bar-toggle').on('click', function(e){
      //    e.preventDefault();
      //    $('#wrapper').toggleClass('right-bar-enabled');
      //});


    },
    //initilizing
    AppziaApp.prototype.init = function() {
        var $this = this;
        this.initTooltipPlugin(),
        this.initPopoverPlugin(),
        this.initNiceScrollPlugin(),
        //document load initialization
        $(document).ready($this.onDocReady);
        //creating portles
        $.Portlet.init();
        //init side bar - left
        $.Sidemenu.init();
        //init fullscreen
        $.FullScreen.init();
    },

    $.AppziaApp = new AppziaApp, $.AppziaApp.Constructor = AppziaApp

}(window.jQuery),

//initializing main application module
function($) {
    "use strict";
    $.AppziaApp.init();
}(window.jQuery);



/* ------------ some utility functions ----------------------- */
//this full screen
var toggle_fullscreen = function () {

}

function executeFunctionByName(functionName, context /*, args */) {
  var args = [].slice.call(arguments).splice(2);
  var namespaces = functionName.split(".");
  var func = namespaces.pop();
  for(var i = 0; i < namespaces.length; i++) {
    context = context[namespaces[i]];
  }
  return context[func].apply(this, args);
}
var w,h,dw,dh;
var changeptype = function(){
    w = $(window).width();
    h = $(window).height();
    dw = $(document).width();
    dh = $(document).height();

    if(jQuery.browser.mobile === true){
        $("body").addClass("mobile").removeClass("fixed-left");
    }

    if(!$("#wrapper").hasClass("forced")){
      if(w > 1024){
        $("body").removeClass("smallscreen").addClass("widescreen");
          $("#wrapper").removeClass("enlarged");
      }else{
        $("body").removeClass("widescreen").addClass("smallscreen");
        $("#wrapper").addClass("enlarged");
        $(".left ul").removeAttr("style");
      }
      if($("#wrapper").hasClass("enlarged") && $("body").hasClass("fixed-left")){
        $("body").removeClass("fixed-left").addClass("fixed-left-void");
      }else if(!$("#wrapper").hasClass("enlarged") && $("body").hasClass("fixed-left-void")){
        $("body").removeClass("fixed-left-void").addClass("fixed-left");
      }

  }
  toggle_slimscroll(".slimscrollleft");
}


var debounce = function(func, wait, immediate) {
  var timeout, result;
  return function() {
    var context = this, args = arguments;
    var later = function() {
      timeout = null;
      if (!immediate) result = func.apply(context, args);
    };
    var callNow = immediate && !timeout;
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
    if (callNow) result = func.apply(context, args);
    return result;
  };
}

function resizeitems(){
  if($.isArray(Menufunction)){
    for (i = 0; i < Menufunction.length; i++) {
        window[Menufunction[i]]();
    }
  }
}

function initscrolls(){
    if(jQuery.browser.mobile !== true){
      //SLIM SCROLL
      $('.slimscroller').slimscroll({
        height: 'auto',
        size: "5px"
      });

      $('.slimscrollleft').slimScroll({
          height: 'auto',
          position: 'right',
          size: "5px",
          color: '#7A868F',
          wheelStep: 5
      });
  }
}
function toggle_slimscroll(item){
    if($("#wrapper").hasClass("enlarged")){
      $(item).css("overflow","inherit").parent().css("overflow","inherit");
      $(item). siblings(".slimScrollBar").css("visibility","hidden");
    }else{
      $(item).css("overflow","hidden").parent().css("overflow","hidden");
      $(item). siblings(".slimScrollBar").css("visibility","visible");
    }
}

var wow = new WOW(
  {
    boxClass: 'wow', // animated element css class (default is wow)
    animateClass: 'animated', // animation css class (default is animated)
    offset: 50, // distance to the element when triggering the animation (default is 0)
    mobile: false        // trigger animations on mobile devices (true is default)
  }
);
wow.init();

/*!
 * passtrength.js
 * Original author: @adrisorribas
 * Further changes, comments: @adrisorribas
 * Licensed under the MIT license
 */
;
(function($, window, document, undefined) {

  var pluginName = "passtrength",
      defaults = {
        minChars: 8,
        passwordToggle: true,
        tooltip: true,
        textWeak: 'Weak',
        textMedium: 'Medium',
        textStrong: 'Strong',
        textVeryStrong: 'Very Strong',
        eyeImg : 'img/eye.svg'
      };

  function Plugin(element, options){
    this.element = element;
    this.$elem = $(this.element);
    this.options = $.extend({}, defaults, options);
    this._defaults = defaults;
    this._name = pluginName;
    _this      = this;
    this.init();
  }

  Plugin.prototype = {
    init: function(){
      var _this    = this,
          meter    = jQuery('<div/>', {class: 'passtrengthMeter'}),
          tooltip = jQuery('<div/>', {class: 'tooltip', text: 'Min ' + this.options.minChars + ' chars'})

      meter.insertAfter(this.element);
      $(this.element).appendTo(meter);

      if(this.options.tooltip){
        tooltip.appendTo(meter);
        var tooltipWidth = tooltip.outerWidth() / 2;
        tooltip.css('margin-left', -tooltipWidth)
      }

      this.$elem.bind('keyup keydown', function(event) {
          value = $(this).val();
          _this.check(value);
      });

      if(this.options.passwordToggle){
        _this.togglePassword();
      }

    },

    check: function(value){
      var secureTotal  = 0,
          chars        = 0,
          capitals     = 0,
          lowers       = 0,
          numbers      = 0,
          special      = 0;
          upperCase    = new RegExp('[A-Z]'),
          numbers      = new RegExp('[0-9]'),
          specialchars = new RegExp('([!,%,&,@,#,$,^,*,?,_,~])');

      if(value.length >= this.options.minChars){
        chars = 1;
      }else{
        chars = -1;
      }
      if(value.match(upperCase)){
        capitals = 1;
      }else{
        capitals = 0;
      }
      if(value.match(numbers)){
        numbers = 1;
      }else{
        numbers = 0;
      }
      if(value.match(specialchars)){
        special = 1;
      }else{
        special = 0;
      }

      secureTotal = chars + capitals + numbers + special;
      securePercentage = (secureTotal / 4) * 100;

      this.addStatus(securePercentage);

    },

    addStatus: function(percentage){
      var status = '',
          text = 'Min ' + this.options.minChars + ' chars',
          meter = $(this.element).closest('.passtrengthMeter'),
          tooltip = meter.find('.tooltip');

      meter.attr('class', 'passtrengthMeter');

      if(percentage >= 25){
        meter.attr('class', 'passtrengthMeter');
        status = 'weak';
        text = this.options.textWeak;
      }
      if(percentage >= 50){
        meter.attr('class', 'passtrengthMeter');
        status = 'medium';
        text = this.options.textMedium;
      }
      if(percentage >= 75){
        meter.attr('class', 'passtrengthMeter');
        status = 'strong';
        text = this.options.textStrong;
      }
      if(percentage >= 100){
        meter.attr('class', 'passtrengthMeter');
        status = 'very-strong';
        text = this.options.textVeryStrong;
      }
      meter.addClass(status);
      if(this.options.tooltip){
        tooltip.text(text);
      }
    },

    togglePassword: function(){
      var buttonShow = jQuery('<span/>', {class: 'showPassword', html: '<img src="'+ this.options.eyeImg +'" />'}),
          input      =  jQuery('<input/>', {type: 'text'}),
          passwordInput      = this;

      buttonShow.appendTo($(this.element).closest('.passtrengthMeter'));
      input.appendTo($(this.element).closest('.passtrengthMeter')).hide();

      $(this.element).bind('keyup keydown', function(event) {
          input.val($(passwordInput.element).val());
      });

      input.bind('keyup keydown', function(event) {
          $(passwordInput.element).val(input.val());
          value = $(this).val();
          _this.check(value);
      });

      $(document).on('click', '.showPassword', function(e) {
        buttonShow.toggleClass('active');
        input.toggle();
        $(passwordInput.element).toggle();
      });
    }
  }

  $.fn[pluginName] = function(options) {
      return this.each(function() {
          if (!$.data(this, "plugin_" + pluginName)) {
              $.data(this, "plugin_" + pluginName, new Plugin(this, options));
          }
      });
  };

})(jQuery, window, document);


$(document).ready(function() {
    $("#sidebar-menu a").each(function() {
        if (this.href == window.location.href) {
            $(this).addClass("active");
            $(this).parent().addClass("active"); // add active to li of the current link
            $(this).parent().parent().prev().addClass("active"); // add active class to an anchor
            $(this).parent().parent().prev().trigger('click'); // click the item to make it drop
        }
    });
    
    $('.logout').click(function(){
      $.ajax({
        url: baseUri,
        method: 'POST',
        dataType: 'json',
        async: false,
        data: {
            action: 'LOGOUT',
        },
        success: function (response) {
            if (response.status === "success") {
                window.location = '/login/';
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
    });
});

// App Init
var Menufunction = [];

function countryFlag (opt) {
  if (!opt.id) { return opt.text; }
  var optimage = $(opt.element).data('image');
  return $('<span><img src="' + optimage + '" class="img-flag" /> ' + $(opt.element).text() + '</span>');
}