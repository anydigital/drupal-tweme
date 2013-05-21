<?php

/**
 * @file
 * Provides theme overrides and implementations for the File Entity module.
 */

/**
 * Preprocesses variables for file_entity.tpl.php.
 */
function tweme_preprocess_file_entity(&$vars) {
  if (isset($vars['filename']) && !empty($vars['filename'])) {
    $vars['content']['caption'] = array(
      '#markup' => '<div class="caption">' . $vars['filename'] . '</div>',
      '#weight' => 100,
    );
  }
}
