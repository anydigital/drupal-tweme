<?php

/**
 * @file
 * Provides forms related theme overrides and implementations.
 */

/**
 * Implements hook_form_FORM_ID_alter() for search_form().
 */
function tweme_form_search_form_alter(&$form, &$form_state) {
  $form['basic']['keys']['#attributes']['placeholder'] = t('Search');
  $form['basic']['keys']['#theme_wrappers'][] = 'search_input_wrapper';
  $form['basic']['submit']['#attributes']['class'][] = 'element-invisible';
}

/**
 * Implements hook_form_FORM_ID_alter() for search_block_form().
 */
function tweme_form_search_block_form_alter(&$form, &$form_state) {
  $form['search_block_form']['#attributes']['placeholder'] = t('Search');
  $form['search_block_form']['#theme_wrappers'][] = 'search_input_wrapper';
  $form['actions']['#attributes']['class'][] = 'element-invisible';
}
