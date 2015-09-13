<?php $classes .= $block_id == 1 ? ' active': '' ?>
<div id="<?php print $block_html_id ?>" class="item jumbotron <?php print $classes ?>" <?php print $attributes ?>>
  <div class="container">
    <?php print render($title_prefix) ?>
    <?php if ($block->subject): ?>
    <h2<?php print $title_attributes ?>><?php print $block->subject ?></h2>
    <?php endif ?>
    <?php print render($title_suffix) ?>
    <div class="content"<?php print $content_attributes ?>>
      <?php print $content ?>
    </div>
  </div>
</div>
