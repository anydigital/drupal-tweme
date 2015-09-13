<?php if ($content): ?>
<?php if ($block_count > 1): ?>
<div id="header-carousel" class="carousel slide <?php print $classes ?>" data-ride="carousel">
  <div class="carousel-inner">
    <?php print $content ?>
  </div>
  <a class="carousel-control left" href="#header-carousel" data-slide="prev">
    <i class="glyphicon glyphicon-chevron-left"></i>
  </a>
  <a class="carousel-control right" href="#header-carousel" data-slide="next">
    <i class="glyphicon glyphicon-chevron-right"></i>
  </a>
</div>
<?php else: ?>
<div class="<?php print $classes ?>">
  <?php print $content ?>
</div>
<?php endif ?>
<?php endif ?>
