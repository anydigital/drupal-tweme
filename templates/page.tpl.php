<?php

/**
 * @file
 * Custom theme implementation to display a single Drupal page.
 */

?>

<!-- NAVBAR -->
<div class="id-navbar navbar navbar-medium navbar-inverse navbar-static-top">
  <div class="navbar-inner">
    <div class="container">
      <?php print $navbar_toggler ?>
      <?php print $navbar_brand ?>
      <?php print $navbar_search ?>
      <?php if ($navbar_menu): ?>
      <nav class="nav-collapse collapse" role="navigation">
        <?php print $navbar_menu ?>
      </nav>
      <?php endif ?>
    </div>
  </div>
</div>

<?php if ($page['featured']): ?>
<!-- FEATURED -->
<div class="zone zone-featured container-wrapper">
  <?php print render($page['featured']) ?>
</div>
<?php endif ?>

<?php if ($has_header): ?>
<!-- HEADER -->
<header class="zone zone-header container-wrapper">
  <div class="container">
    <div class="zone-inner">
      <?php print $headline ?>
      <?php print $messages ?>
      <?php print render($page['header']) ?>
      <?php print render($page['help']) ?>
      <?php print $controls ?>
    </div>
  </div>
</header>
<?php endif ?>

<?php if ($page['highlighted']): ?>
<!-- HIGHLIGHTED -->
<header class="zone zone-highlighted zone-annex container-wrapper">
  <div class="container">
    <div class="zone-inner mkt size-l align-center">
      <?php print render($page['highlighted']) ?>
    </div>
  </div>
</header>
<?php endif ?>

<!-- MAIN -->
<div class="zone zone-main container-wrapper">
  <div class="container">
    <div class="zone-inner id-pin-to">
      <div class="row-fluid">
        <?php if ($has_sidebar_first): ?>
        <!-- SIDEBAR FIRST -->
        <aside class="span3">
          <div class="sidebar sidebar-first">
            <?php print render($page['sidebar_first']) ?>
            <?php print render($page['sidebar_first_affix']) ?>
          </div>
        </aside>
        <?php endif ?>
        <!-- CONTENT -->
        <section class="span<?php print 12 - 3 * $has_sidebar_first - 3 * $has_sidebar_second ?>">
          <?php print render($page['content']) ?>
        </section>
        <?php if ($has_sidebar_second): ?>
        <!-- SIDEBAR SECOND -->
        <aside class="span3">
          <div class="sidebar sidebar-second">
            <?php print render($page['sidebar_second']) ?>
            <?php print render($page['sidebar_second_affix']) ?>
          </div>
        </aside>
        <?php endif ?>
      </div>
    </div>
  </div>
</div>

<?php if ($page['bottom']): ?>
<!-- BOTTOM -->
<header class="zone zone-bottom zone-annex container-wrapper">
  <div class="container">
    <div class="zone-inner">
      <?php print render($page['bottom']) ?>
    </div>
  </div>
</header>
<?php endif ?>

<!-- FOOTER -->
<footer class="zone zone-footer container-wrapper">
  <div class="container">
    <div class="zone-inner size-s align-center">
      <?php print $page['footer'] ? render($page['footer']) : $copyright ?>
      <?php if ($secondary_menu): ?>
      <div class="footer-links">
        <?php foreach ($secondary_menu as $item): ?>
        <?php print l($item['title'], $item['href']) ?>
        <?php endforeach ?>
      </div>
      <?php endif ?>
      <?php if ($feed_icons): ?>
      <div class="footer-icons"><?php print $feed_icons ?></div>
      <?php endif ?>
    </div>
  </div>
</footer>
