(function($) {
  var $notiny, appendToContainer, closeAction, containers, createNotification, defaults, detectCSSFeature, prepareNotification, showAction, themedefaults;
  $notiny = $('<div class="notiny" />').appendTo($('body'));
  defaults = {
    title: 'Información',
    position: 'right-top',
    theme: 'info',
    template: '<div class="notiny-base"><b class="notiny-title"><i id="notiny-icon" class="fa"></i> </b><br><span class="notiny-text"></span></div>',
    width: '300',
    text: '',
    background: true,
    autohide: true,
    clickhide: true,
    delay: 3000,
    animate: true,
    animation_show: 'notiny-animation-show 0.4s forwards',
    animation_hide: 'notiny-animation-hide 5s forwards'
  };
  themedefaults = {

    /*
     * Blocks order:
     * | container
     * | - base
     * | -- image
     * | -- text
     * | - base
     * | -- image
     * | -- text
     * | ...
     */
    container_class: '',
    notification_class: '',
    text_class: '',
    icon_class: ''
  };
  /*
   * List of possible containers
   */
  containers = {
    'left-top': $('<div />', {
      "class": 'notiny-container',
      css: {
        top: 10,
        left: 10
      }
    }).appendTo($notiny),
    'left-bottom': $('<div />', {
      "class": 'notiny-container',
      css: {
        bottom: 10,
        left: 10
      }
    }).appendTo($notiny),
    'right-top': $('<div />', {
      "class": 'notiny-container',
      css: {
        top: 10,
        right: 10
      }
    }).appendTo($notiny),
    'right-bottom': $('<div />', {
      "class": 'notiny-container',
      css: {
        bottom: 10,
        right: 10
      }
    }).appendTo($notiny),
    'fluid-top': $('<div />', {
      "class": 'notiny-container notiny-container-fluid-top',
      css: {
        top: 0,
        left: 0,
        right: 0
      }
    }).appendTo($notiny),
    'fluid-bottom': $('<div />', {
      "class": 'notiny-container notiny-container-fluid-bottom',
      css: {
        bottom: 0,
        left: 0,
        right: 0
      }
    }).appendTo($notiny)
  };
  detectCSSFeature = function(featurename) {
    var domPrefixes, elm, feature, featurenameCapital, i;
    feature = false;
    domPrefixes = 'Webkit Moz ms O'.split(' ');
    elm = document.createElement('div');
    featurenameCapital = null;
    featurename = featurename.toLowerCase();
    if (elm.style[featurename] !== void 0) {
      feature = true;
    }
    if (feature === false) {
      featurenameCapital = featurename.charAt(0).toUpperCase() + featurename.substr(1);
      i = 0;
      while (i < domPrefixes.length) {
        if (elm.style[domPrefixes[i] + featurenameCapital] !== void 0) {
          feature = true;
          break;
        }
        i++;
      }
    }
    return feature;
  };
  closeAction = function($notification, settings) {
    if (settings.animate) {
      if (!settings._state_closing) {
        settings._state_closing = true;
        if (detectCSSFeature('animation') && detectCSSFeature('transform')) {
          $notification.css('animation', settings.animation_hide);
          setTimeout((function() {
            $notification.remove();
          }), 300);
        } else {
          $notification.fadeOut(300, function() {
            $notification.remove();
          });
        }
      }
    } else {
      $notification.remove();
    }
  };
  showAction = function($notification, settings) {
    if (settings.animate) {
      if (detectCSSFeature('animation') && detectCSSFeature('transform')) {
        $notification.css('animation', settings.animation_show);
      } else {
        $notification.hide();
        $notification.fadeIn(500);
      }
    }
  };
  prepareNotification = function(options) {
    createNotification($.extend({}, defaults, options));
  };
  createNotification = function(settings) {
    var $icon, $title, $notification, $ptext;
    $notification = $(settings.template);
    settings.theme = $.notiny.themes[settings.theme];
    $notification.addClass(settings.theme.notification_class);
    $ptext = $notification.find('.notiny-text');
    $ptext.addClass(settings.theme.text_class);
    $ptext.append(settings.text);
    //Personal code
    $icon = $notification.find('#notiny-icon');
    $title = $notification.find('.notiny-title');
    $icon.addClass(settings.theme.icon_class);
    $title.append(settings.title);
    if (settings.position.indexOf('fluid') === -1) {
      $notification.css('width', settings.width);
    }
    $notification.data('settings', settings);
    appendToContainer($notification, settings);
    return $notification;
  };
  appendToContainer = function($notification, settings) {
    var $container, floatclear;
    $container = containers[settings.position];
    $container.addClass(settings.theme.container_class);
    if (settings.position.slice(-3) === 'top') {
      $container.prepend($notification);
    } else {
      $container.append($notification);
    }
    floatclear = settings.position.split('-')[0];
    $notification.css('float', floatclear);
    $notification.css('clear', floatclear);
    settings._state_closing = false;
    if (settings.clickhide) {
      $notification.css('cursor', 'pointer');
      $notification.on('click', function() {
        closeAction($notification, settings);
        return false;
      });
    }
    if (settings.autohide) {
      setTimeout((function() {
        closeAction($notification, settings);
      }), settings.delay + 500);
    }
    showAction($notification, settings);
  };
  $.notiny = function(options) {
    prepareNotification(options);
    return this;
  };
  $.notiny.addTheme = function(name, options) {
    var settings;
    settings = $.extend({}, themedefaults, options);
    (this.themes = this.themes || {})[name] = settings;
  };
  $.notiny.close = function($notiny) {
    closeAction($notiny, $notiny.data('settings'));
  };
  $.notiny.addTheme('info', {
    notification_class: 'notiny-theme-info notiny-default-vars',
    icon_class: 'fa-check'
  });
  $.notiny.addTheme('light', {
    notification_class: 'notiny-theme-light notiny-default-vars',
    icon_class: 'fa-newspaper-o'
  });
  $.notiny.addTheme('danger', {
    notification_class: 'notiny-theme-danger notiny-default-vars',
    icon_class: 'fa-close'
  });
  $.notiny.addTheme('success', {
    notification_class: 'notiny-theme-success notiny-default-vars',
    icon_class: 'fa-check'
  });
})(jQuery);
