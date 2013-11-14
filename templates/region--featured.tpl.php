<?php

/**
 * @file
 * Custom theme implementation to display a carousel.
 */

?>
<?php if ($content): ?>
<div class="id-featured carousel slide">
  <div class="carousel-inner">
    <?php print $content ?>
  </div>
  <a class="carousel-control carousel-control-modern left" href=".id-featured" data-slide="prev">&lsaquo;</a>
  <a class="carousel-control carousel-control-modern right" href=".id-featured" data-slide="next">&rsaquo;</a>
</div>
<?php endif ?>
