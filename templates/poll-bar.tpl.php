<?php

/**
 * @file
 * Custom theme implementation to display the bar for a single choice in a
 * poll.
 */

?>
<small class="pull-right"><?php print $percentage ?>%</small>
<?php print $title ?>
<div class="progress">
  <div class="bar" style="width: <?php print $percentage ?>%"></div>
</div>
