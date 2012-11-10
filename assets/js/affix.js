(function ($) {
  $(document).ready(function() {
    var ss = $('.region-sidebar-second');
    if (ss.size()) {
      var offset = {
        top: ss.offset().top - 20,
        bottom: $('#footer').outerHeight() + 20
      }
      ss.width(ss.width());
      ss.affix({ offset: offset });
      $('head').append('<style>#sidebar .affix-bottom { bottom: ' + offset.bottom + 'px }</style>');
    }
  });
})(jQuery);
