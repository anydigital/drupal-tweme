<div id="<?php print $block_html_id ?>" class="header-body <?php print $classes ?>"<?php print $attributes ?>>
  <div class="container">
    <?php print render($title_prefix) ?>
    <?php if ($block->subject): ?>
    <h1<?php print $title_attributes ?>><?php print $block->subject ?></h1>
    <?php endif ?>
    <?php print render($title_suffix) ?>
    <?php print $content ?>
  </div>
</div>
