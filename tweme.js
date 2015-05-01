(function($) {
  $(function () {
    $('.navbar-nav .dropdown-toggle').on('click', function () {
      window.location.href = $(this).attr('href');
    });
    $('.footer.has-sitemap .menu > li').addClass('col-sm-6 col-md-4 col-lg-2');
    $('.footer.has-sitemap .menu').removeClass().addClass('footer-sitemap list-unstyled row');
    $('.footer.has-sitemap .dropdown-menu').removeClass().addClass('nav');
  });
})(jQuery);
