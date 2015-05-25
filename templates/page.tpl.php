<?php print render($page['body_top']) ?>

<div class="<?php print $navbar_classes ?>">
  <div class="container">
    <div class="navbar-header">
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
</div>

<header class="header zone">
  <div class="header-body<?php print $page['header'] || $page['featured'] ? ' header-top' : '' ?>">
    <div class="container">
      <?php print $breadcrumb ?>
      <?php print render($title_prefix) ?>
      <?php if (!(empty($title) || $page['header'] || $page['featured'])): ?>
      <h1><?php print $title ?></h1>
      <?php endif ?>
      <?php print render($title_suffix) ?>
    </div>
  </div>
  <?php print render($page['header']) ?>
  <?php print render($page['featured']) ?>
  <div class="header-bottom">
    <div class="container">
      <?php if (!empty($action_links)): ?>
      <ul class="action-links pull-right">
        <?php print render($action_links) ?>
      </ul>
      <?php endif ?>
      <?php print render($tabs) ?>
    </div>
  </div>
</header>

<section class="main zone">
  <div class="container">
    <?php print $messages ?>
    <?php print render($page['help']) ?>
    <?php print render($page['highlighted']) ?>
    <?php print render($page['content']) ?>
  </div>
</section>

<?php print render($page['share']) ?>

<?php if ($page['bottom']): ?>
<section class="bottom zone">
  <div class="container">
    <?php print render($page['bottom']) ?>
  </div>
</section>
<?php endif ?>

<footer class="footer zone has-sitemap">
  <div class="container">
    <?php print $page['footer'] ? render($page['footer']) : '©' . date('Y') . ' ' . $site_name ?>
  </div>
</footer>

<?php print render($page['body_bottom']) ?>
