<?php

/**
 * @file
 * Custom theme implementation to display a carousel.
 */

?>
<?php if ($content): ?>
<div id="featured" class="carousel slide">
  <!-- Carousel items -->
  <div class="carousel-inner">
    <?php print $content ?>
  </div>
  <!-- Carousel nav -->
  <a class="carousel-control carousel-control-modern left" href="#featured" data-slide="prev">&lsaquo;</a>
  <a class="carousel-control carousel-control-modern right" href="#featured" data-slide="next">&rsaquo;</a>
</div>
<?php endif ?>
