<?php

/**
 * @file
 * Provides theme overrides and implementations for the search module.
 */

/**
 * Implements hook_form_FORM_ID_alter() for search_form.
 */
function tweme_form_search_form_alter(&$form, &$form_state) {
  $form['basic']['keys']['#attributes']['placeholder'] = t('Search');
  $form['basic']['keys']['#theme_wrappers'][] = 'search_input_wrapper';
  $form['basic']['submit']['#attributes']['class'][] = 'element-invisible';
}

/**
 * Implements hook_form_FORM_ID_alter() for search_block_form.
 */
function tweme_form_search_block_form_alter(&$form, &$form_state) {
  $form['search_block_form']['#attributes']['placeholder'] = t('Search');
  $form['search_block_form']['#theme_wrappers'][] = 'search_input_wrapper';
  $form['actions']['#attributes']['class'][] = 'element-invisible';
}

/**
 * Adds the search button right after the search input element.
 */
function tweme_search_input_wrapper($vars) {
  $out = '<div class="input-append">';
  $out .= $vars['element']['#children'];
  $out .= '<button type="submit" class="btn">';
  $out .= '<i class="icon-search"></i>';
  $out .= '<span class="element-invisible">' . t('Search') . '</span>';
  $out .= '</button>';
  $out .= '</div>';
  return $out;
}
