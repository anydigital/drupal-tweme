<header class="<?php print $navbar_classes ?>">
  <div class="container">
    <div class="navbar-header">
      <?php if ($logo): ?>
      <a class="logo navbar-btn pull-left" href="<?php print $front_page ?>" title="<?php print t('Home') ?>">
        <img src="<?php print $logo ?>" alt="<?php print t('Home') ?>" />
      </a>
      <?php endif ?>
      <?php if (!empty($site_name)): ?>
      <a class="name navbar-brand" href="<?php print $front_page ?>" title="<?php print t('Home') ?>">
        <?php print $site_name ?>
      </a>
      <?php endif ?>
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <?php if (!empty($primary_nav) || !empty($secondary_nav) || !empty($page['navigation'])): ?>
      <div class="navbar-collapse collapse">
        <nav role="navigation">
          <?php print render($primary_nav) ?>
          <?php print render($secondary_nav) ?>
          <?php print render($page['navigation']) ?>
        </nav>
      </div>
    <?php endif ?>
  </div>
</header>

<header class="header zone">
  <div class="zone-inner">
    <?php if (empty($page['featured'])): ?><div class="container"><?php endif ?>
    <div class="header-top">
      <?php print $breadcrumb ?>
      <?php print render($title_prefix) ?>
      <?php if (!empty($title)): ?>
      <h1 class="page-header"><?php print $title ?></h1>
      <?php endif ?>
      <?php print render($title_suffix) ?>
      <?php print render($page['header']) ?>
    </div>
    <?php print render($page['featured']) ?>
    <div class="header-bottom">
      <?php print render($tabs) ?>
      <?php if (!empty($action_links)): ?>
      <ul class="action-links"><?php print render($action_links) ?></ul>
      <?php endif ?>
    </div>
    <?php if (empty($page['featured'])): ?></div><?php endif ?>
  </div>
</header>

<section class="main zone">
  <div class="zone-inner">
    <div class="container">
      <?php print $messages ?>
      <?php print render($page['help']) ?>
      <?php print render($page['highlighted']) ?>
      <?php print render($page['content']) ?>
    </div>
  </div>
</section>

<?php if ($page['bottom']): ?>
<header class="bottom zone">
  <div class="zone-inner">
    <div class="container">
      <?php print render($page['bottom']) ?>
    </div>
  </div>
</header>
<?php endif ?>

<footer class="footer zone">
  <div class="zone-inner">
    <div class="container">
      <?php print $page['footer'] ? render($page['footer']) : '©' . date('Y') . ' ' . $site_name ?>
    </div>
  </div>
</footer>
