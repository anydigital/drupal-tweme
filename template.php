<?php

/**
 * Implements hook_css_alter().
 */
function tweme_css_alter(&$css) {
  unset($css['modules/poll/poll.css']);
}
