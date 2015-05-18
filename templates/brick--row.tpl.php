<?php print $prefix ?>
<?php print $view_mode == 'teaser' ? '&lt;Row&gt;' : '' ?>
<?php if ($bricks): ?>
<?php $_class = 'col-md-' . 12 / count($bricks) ?>
<div class="row">
  <?php foreach ($bricks as $brick): ?>
  <div class="col <?php print $_class ?>">
    <?php print render($brick) ?>
  </div>
  <?php endforeach ?>
</div>
<?php endif ?>
<?php print $suffix ?>
