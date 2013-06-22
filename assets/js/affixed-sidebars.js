(function ($) {
  var TWEME_AFFIX_OFFSET = 20;
  $(document).ready(function() {
    tweme_affix_sidebar('.region-sidebar-first-affix');
    tweme_affix_sidebar('.region-sidebar-second-affix');
  });
  function tweme_affix_sidebar(selector) {
    var sidebar = $(selector);
    if (sidebar.size()) {
      var offset = {
        top: sidebar.offset().top - TWEME_AFFIX_OFFSET,
        bottom: $('#footer').outerHeight() + TWEME_AFFIX_OFFSET
      }
      sidebar.width(sidebar.width());
      $('head').append('<style>' + selector + '.affix { top: ' + TWEME_AFFIX_OFFSET + 'px; }</style>');
      $('head').append('<style>' + selector + '.affix-bottom { position: absolute; top: auto; bottom: ' + offset.bottom + 'px; }</style>');
      sidebar.affix({ offset: offset });
    }
  }
})(jQuery);
