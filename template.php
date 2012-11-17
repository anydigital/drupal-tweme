<?php

/**
 * @file
 * Provides preprocess logic and other functionality for theming.
 */

// Includes:
include_once DRUPAL_ROOT . '/' . drupal_get_path('theme', 'tweme') . '/includes/menu.inc';

/**
 * Implements hook_css_alter().
 */
function tweme_css_alter(&$css) {
  unset($css[drupal_get_path('module', 'poll') . '/poll.css']);
}

/**
 * Implements hook_process_page().
 */
function tweme_process_page(&$vars) {
  $page = $vars['page'];

  // Prepare some useful variables.
  $vars['has_header'] = !empty($vars['title']) || !empty($vars['messages']);
  $vars['has_sidebar_first'] = !empty($page['sidebar_first']) || !empty($page['sidebar_first_affix']);
  $vars['has_sidebar_second'] = !empty($page['sidebar_second']) || !empty($page['sidebar_second_affix']);
  $vars['content_cols'] = 12 - 3 * (int) $vars['has_sidebar_first'] - 3 * (int) $vars['has_sidebar_second'];

  // Render and clean up navbar search form.
  $vars['navbar_search'] = drupal_render($vars['navbar_search']);
  $vars['navbar_search'] = strip_tags($vars['navbar_search'], '<form><input>');
}

/**
 * Implements hook_preprocess_page().
 */
function tweme_preprocess_page(&$vars) {
  $page = $vars['page'];

  // Build navbar menu.
  $menu_id = variable_get('menu_main_links_source', 'main-menu');
  $menu_tree = menu_tree($menu_id);
  $vars['navbar_menu'] = drupal_render($menu_tree);

  // Build navbar search form.
  $vars['navbar_search'] = FALSE;
  if (module_exists('search')) {
    $vars['navbar_search'] = drupal_get_form('_tweme_navbar_search_form');
    // Add custom classes.
    $vars['navbar_search']['#attributes']['class'][] = 'navbar-search-elastic';
    $vars['navbar_search']['#attributes']['class'][] = 'pull-right';
    $vars['navbar_search']['#attributes']['class'][] = 'hidden-phone';
  }

  // Connect Twitter's Bootstrap framework using Libraries API.
  if (module_exists('libraries') && $bootstrap_path = libraries_get_path('bootstrap')) {
    drupal_add_css($bootstrap_path . '/css/bootstrap.css', array('media' => 'all'));
    drupal_add_css($bootstrap_path . '/css/bootstrap-responsive.css', array('media' => 'screen'));
    drupal_add_js($bootstrap_path . '/js/bootstrap.js');
  }
  else {
    // Notify a user if Bootstrap library was not found.
    drupal_set_message(t('Bootstrap library was not found. Download it <a href="http://twitter.github.com/bootstrap/">here</a> and put inside <code>sites/all/libraries/</code> folder.'), 'error');
  }

  // Special behavior for Tweme only (not for subthemes).
  if (_tweme_is_tweme()) {
    $tweme_path = drupal_get_path('theme', 'tweme');
    drupal_add_js($tweme_path . '/assets/js/affix.js');
  }
}

/**
 * Implements hook_preprocess_block().
 */
function tweme_preprocess_block(&$vars) {
  $block = $vars['block'];

  if (_tweme_is_tweme()) {
    if ($block->region == 'featured') {
      $vars['classes_array'][] = 'item';
      if ($vars['block_id'] == 1) {
        $vars['classes_array'][] = 'active';
      }
      $vars['content'] = '<h1>' . $vars['block']->subject . '</h1>' . $vars['content'];
      $vars['block']->subject = '';
    }
  }
}

/**
 * Implements hook_preprocess_poll_bar().
 */
function tweme_preprocess_poll_bar(&$vars) {
  $vars['theme_hook_suggestions'] = array('poll_bar');
}

/**
 * Implements hook_preprocess_button().
 */
function tweme_preprocess_button(&$vars) {
  $vars['element']['#attributes']['class'][] = 'btn';
  if (isset($vars['element']['#parents'][0]) && $vars['element']['#parents'][0] == 'submit') {
    $vars['element']['#attributes']['class'][] = 'btn-primary';
  }
}

/**
 * Implements theme_menu_local_tasks().
 */
function tweme_menu_local_tasks(&$vars) {
  $output = '';
  if (!empty($vars['primary'])) {
    $vars['primary']['#prefix'] = '<ul class="nav nav-tabs">';
    $vars['primary']['#suffix'] = '</ul>';
    $output .= drupal_render($vars['primary']);
  }
  if (!empty($vars['secondary'])) {
    $vars['secondary']['#prefix'] = '<ul class="nav nav-pills">';
    $vars['secondary']['#suffix'] = '</ul>';
    $output .= drupal_render($vars['secondary']);
  }
  return $output;
}

/**
 * Implements theme_item_list().
 */
function tweme_item_list($vars) {
  if (isset($vars['attributes']['class']) && in_array('pager', $vars['attributes']['class'])) {
    // Adjust pager output.
    unset($vars['attributes']['class']);
    foreach ($vars['items'] as $i => &$item) {
      if (in_array('pager-current', $item['class'])) {
        $item['class'] = array('active');
        $item['data'] = '<a href="#">' . $item['data'] . '</a>';
      }
      elseif (in_array('pager-ellipsis', $item['class'])) {
        $item['class'] = array('disabled');
        $item['data'] = '<a href="#">' . $item['data'] . '</a>';
      }
    }
    return '<div class="pagination pagination-centered">' . theme_item_list($vars) . '</div>';
  }
  return theme_item_list($vars);
}

/**
 * Helper function: returns a navbar search form.
 */
function _tweme_navbar_search_form($form, &$form_state) {
  $form = search_form($form, $form_state);

  // Set additional attributes.
  $form['#attributes']['class'][] = 'navbar-search';
  $form['basic']['keys']['#title'] = '';
  $form['basic']['keys']['#attributes']['class'][] = 'search-query';
  $form['basic']['keys']['#attributes']['placeholder'] = t('Search');

  // Unset unnecessary data and attributes.
  unset($form['basic']['submit']);
  unset($form['basic']['#type']);
  unset($form['basic']['#attributes']);

  return $form;
}

/**
 * Helper function: returns TRUE if current theme is Tweme.
 */
function _tweme_is_tweme() {
  global $theme;
  return $theme == 'tweme';
}
