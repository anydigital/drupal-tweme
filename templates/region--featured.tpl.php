<?php

/**
 * @file
 * Custom theme implementation to display a carousel.
 */

?>
<?php if ($content): ?>
<div id="carousel" class="carousel slide">
  <!-- Carousel items -->
  <div class="carousel-inner">
    <?php print $content ?>
  </div>
  <!-- Carousel nav -->
  <a class="carousel-control left" href="#carousel" data-slide="prev">&lsaquo;</a>
  <a class="carousel-control right" href="#carousel" data-slide="next">&rsaquo;</a>
</div>
<?php endif ?>
