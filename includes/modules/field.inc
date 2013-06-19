<?php

/**
 * @file
 * Provides theme overrides and implementations for the Field module.
 */

/**
 * Overrides theme_field__FIELD_ID() for field_tags.
 */
function tweme_field__field_tags($vars) {
  $out = '';
  foreach ($vars['items'] as $item) {
    $item['#options']['attributes']['class'][] = 'badge';
    $out .= ' ' . drupal_render($item);
  }
  return '<div class="'. $vars['field_name_css'] .'">' . $out . '</div>';
}
