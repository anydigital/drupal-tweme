<?php if ($page['hidden']): ?><div class="hide"><?php print render($page['hidden']) ?></div><?php endif ?>

<!-- Navbar -->
<div id="navbar" class="navbar navbar-inverse navbar-static-top">
	<div class="navbar-inner">
		<div class="container">
			<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="brand" href="<?php print $front_page ?>" title="<?php print $site_slogan ?>"><?php print $site_name ?></a>
			<?php if ($main_menu): ?>
			<nav class="nav-collapse collapse" role="navigation">
				<ul class="nav">
					<?php foreach ($main_menu as $item): ?>
					<li class="<?php print drupal_match_path(current_path(), $item['href']) ? 'active' : '' ?>">
						<?php print l($item['title'], $item['href']) ?>
					</li>
					<?php endforeach ?>
				</ul>
			</nav>
			<?php endif ?>
		</div>
	</div>
</div>

<?php if ($title): ?>
<!-- Header -->
<header id="header" class="container-wrapper">
  <div class="container">
    <?php if ($title): ?>
    <?php print $breadcrumb ?>
    <?php print render($title_prefix) ?>
    <h1><?php print $title ?></h1>
    <?php print render($title_suffix) ?>
    <?php endif ?>
    <?php print render($page['help']) ?>
    <?php if ($tabs): ?><?php print render($tabs) ?><?php endif ?>
    <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links) ?></ul><?php endif ?>
  </div>
</header>
<?php endif ?>

<!-- Main -->
<div id="main">
  <div class="container">
    <?php if (user_access('administer')) print $messages ?>
    <div class="row">
      <?php $sidebar_cols = 3 * (int) !empty($page['sidebar_first']) + 1 * (int) !empty($page['sidebar_second']) ?>
      <?php $scrollspy_cols = 3 * (int) !empty($scrollspy) ?>
      <?php $content_cols = 12 - $sidebar_cols - $scrollspy_cols ?>
  
      <?php if ($scrollspy): ?>
      <!-- ScrollSpy -->
      <aside id="scrollspy" class="span3 hidden-phone">
        <div data-spy="affix" data-offset-top="200">
          <div class="row">
            <div class="span3">
              <nav>
                <ul class="nav nav-tabs nav-stacked">
                  <li><a href="#up"><i class="icon icon-chevron-up"></i><?php print t('Back to top') ?></a></li>
                  <?php foreach ($scrollspy as $item): ?>
                  <li><a href="<?php print $item['href'] ?>"><i class="icon icon-chevron-right"></i><?php print $item['title'] ?></a></li>
                  <?php endforeach ?>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </aside>
      <?php endif ?>

      <!-- Content -->
      <section id="content" class="span<?php print $content_cols ?>">
        <?php print render($page['content']) ?>
      </section>

      <?php if ($page['sidebar_first']): ?>
      <!-- Sidebar first -->
      <aside class="span3">
        <?php print render($page['sidebar_first']) ?>
      </aside>
      <?php endif ?>

      <?php if ($page['sidebar_second']): ?>
      <!-- Sidebar second -->
      <aside class="span1 hidden-phone">
        <div data-spy="affix" data-offset-top="200">
          <div class="row">
            <div class="span1">
            <?php print render($page['sidebar_second']) ?>
            </div>
          </div>
        </div>
      </aside>
      <?php endif ?>
      
    </div>
	</div>
</div>

<!-- Footer -->
<footer id="footer" class="container-wrapper">
	<div class="container">
    <div class="footer-links pull-right">
      <?php if ($feed_icons): ?><?php print $feed_icons ?><?php endif ?>
      <?php if ($secondary_menu): ?>
			<?php foreach ($secondary_menu as $item): ?>
			<?php print l($item['title'], $item['href']) ?>
			<?php endforeach ?>
      <a href="#up"><?php print t('Back to top') ?> </a>
      <?php endif ?>
    </div>
    <?php print date('Y') ?> © <?php print $site_name ?>
	</div>
</footer>
