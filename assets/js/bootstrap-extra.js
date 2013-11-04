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
  function insert_number(i) {
    $(this).wrapInner('<div class="inner"></div>');
    $(this).prepend('<div class="number">' + (i + 1).toString() + '</div>');
  }
})(jQuery);
