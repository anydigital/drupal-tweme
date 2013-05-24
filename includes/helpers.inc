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
