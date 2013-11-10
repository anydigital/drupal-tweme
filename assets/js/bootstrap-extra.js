(function ($) {

  $(document).ready(function() {
    $('ol.numbered').each(function() {
      $(this).addClass('unstyled');
      $(this).children('li').each(insert_number);
    });
    $('dl.numbered').each(function() {
      $(this).children('dt').each(insert_number);
    });
  });

  $(window).load(function() {
    $('*[data-spy="pin"]').each(smart_pin_init);
    $(window).scroll(function() {
      $('*[data-spy="pin"]').each(smart_pin_handler);
    });
    $(window).resize(function() {
      $('*[data-spy="pin"]').each(smart_pin_init);
    });
  });

  function insert_number(i) {
    $(this).wrapInner('<div class="inner"></div>');
    $(this).prepend('<div class="number">' + (i + 1).toString() + '</div>');
  }

  function smart_pin_init() {
    var container = $($(this).attr('data-pin-container'));
    if (!container) return;

    var spacing = (container.outerHeight() - container.height()) / 2;

    container.css('position', 'relative');

    $(this).width($(this).parent().width());
    $(this).attr('data-offset-min', $(this).offset().top - spacing);
    $(this).attr('data-offset-max', container.offset().top + container.height() - $(this).height());
    $(this).attr('data-pin-spacing', spacing);

    smart_pin_handler.call($(this));
  }

  function smart_pin_handler() {
    if ($(document).scrollTop() <= $(this).attr('data-offset-min')) {
      $(this).css('position', 'static');
    }
    else if ($(document).scrollTop() < $(this).attr('data-offset-max')) {
      $(this).css('position', 'fixed');
      $(this).css('top', $(this).attr('data-pin-spacing').toString() + 'px');
      $(this).css('bottom', 'auto');
    }
    else {
      $(this).css('position', 'absolute');
      $(this).css('top', 'auto');
      $(this).css('bottom', $(this).attr('data-pin-spacing').toString() + 'px');
    }
  }

})(jQuery);
