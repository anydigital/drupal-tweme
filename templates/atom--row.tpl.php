<?php print $prefix ?>
<?php print $view_mode == 'teaser' ? '&lt;Row&gt;' : '' ?>
<?php if ($atoms): ?>
<?php $_class = 'col-md-' . 12 / count($atoms) ?>
<div class="row">
  <?php foreach ($atoms as $atom): ?>
  <div class="col <?php print $_class ?>">
    <?php print render($atom) ?>
  </div>
  <?php endforeach ?>
</div>
<?php endif ?>
<?php print $suffix ?>
