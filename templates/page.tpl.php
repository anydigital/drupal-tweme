<?php

/**
 * @file
 * Custom theme implementation to display a single Drupal page.
 */

?>

<!-- Navbar -->
<div id="navbar" class="navbar navbar-medium navbar-inverse navbar-static-top">
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

<?php if ($page['header'] || $page['featured']): ?>
<!-- Header -->
<div id="header" class="zone container-wrapper hidden-phone">
  <div class="container">
    <div class="inner mkt size-m align-center">
      <?php print render($page['header']) ?>
      <?php print render($page['featured']) ?>
    </div>
  </div>
</div>
<?php endif ?>

<?php if ($page['highlighted']): ?>
<!-- Highlighted -->
<header id="highlighted" class="zone container-wrapper">
  <div class="container">
    <div class="inner mkt size-l align-center">
      <?php print render($page['highlighted']) ?>
    </div>
  </div>
</header>
<?php endif ?>

<?php if ($preface): ?>
<!-- Preface -->
<header id="preface" class="zone container-wrapper">
  <div class="container">
    <div class="inner">
      <?php print $preface ?>
    </div>
  </div>
</header>
<?php endif ?>

<!-- Main -->
<div id="main" class="zone container-wrapper">
  <div class="container">
    <div class="inner">
      <?php print $messages ?>
      <div class="row row-toggle">
        <?php if ($has_sidebar_first): ?>
        <!-- Sidebar first -->
        <aside id="sidebar-first" class="sidebar span3 hidden-phone">
          <?php print render($page['sidebar_first']) ?>
          <?php print render($page['sidebar_first_affix']) ?>
        </aside>
        <?php endif ?>
        <!-- Content -->
        <section id="content" class="span<?php print 12 - 3 * $has_sidebar_first - 3 * $has_sidebar_second ?>">
          <?php print render($page['content']) ?>
        </section>
        <?php if ($has_sidebar_second): ?>
        <!-- Sidebar second -->
        <aside id="sidebar-second" class="sidebar span3 hidden-phone">
          <?php print render($page['sidebar_second']) ?>
          <?php print render($page['sidebar_second_affix']) ?>
        </aside>
        <?php endif ?>
      </div>
    </div>
	</div>
</div>

<!-- Footer -->
<footer id="footer" class="zone container-wrapper">
	<div class="container">
    <div class="inner size-s align-center">
      <?php if ($page['footer']): ?>
      <?php print render($page['footer']) ?>
      <?php else: ?>
      <?php print $copyright ?>
      <?php endif ?>
      <div class="footer-links">
        <?php if ($feed_icons): ?><?php print $feed_icons ?><?php endif ?>
        <?php if ($secondary_menu): ?>
        <?php foreach ($secondary_menu as $item): ?>
        <?php print l($item['title'], $item['href']) ?>
        <?php endforeach ?>
        <?php endif ?>
      </div>
    </div>
	</div>
</footer>
