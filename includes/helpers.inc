<?php

/**
 * @file
 * Provides helper functions.
 */

/**
 * Parses title.
 */
function _tweme_parse_title($title) {
  $subtitle = '';
  if (strpos($title, ' ~ ')) {
    $parts = explode(' ~ ', $title);
    $title = trim($parts[0]);
    $subtitle = trim($parts[1]);
  }
  return array($title, $subtitle);
}

/**
  * Displays message for admin.
  */
function _tweme_admin_message($message, $type = 'status') {
  if (user_access('administer')) {
    drupal_set_message('Tweme: ' . $message, $type);
  }
}

/**
  * Returns markup of all blocks in the region.
  */
function _tweme_region_blocks_markup($region) {
  $elems = block_get_blocks_by_region($region);
  if (is_array($elems)) {
    foreach ($elems as &$elem) {
      if (isset($elem['#theme_wrappers'])) {
        unset($elem['#theme_wrappers']);
      }
    }
    return drupal_render($elems);
  }
  return FALSE;
}
