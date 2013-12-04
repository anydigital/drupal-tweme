<?php

/**
 * @file
 * Provides theme overrides and implementations for the Field module.
 */

/**
 * Preprocesses variables for theme_field().
 */
function tweme_preprocess_field(&$vars) {
  $elem = $vars['element'];
  if ($elem['#field_type'] == 'taxonomy_term_reference') {
    foreach ($vars['items'] as &$item) {
      $item['#options']['attributes']['class'][] = 'badge';
    }
  }
}
