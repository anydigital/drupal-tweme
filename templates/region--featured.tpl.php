<?php if ($content): ?>
<div id="featured" class="<?php print $classes ?> carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <?php print $content ?>
  </div>
  <a class="carousel-control left" href="#featured" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="carousel-control right" href="#featured" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
</div>
<?php endif ?>
