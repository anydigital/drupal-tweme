<?php if ($content): ?>
<div class="<?php print $classes ?> carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <?php print $content ?>
  </div>
  <a class="carousel-control left" href=".region-featured" data-slide="prev">&lsaquo;</a>
  <a class="carousel-control right" href=".region-featured" data-slide="next">&rsaquo;</a>
</div>
<?php endif ?>
