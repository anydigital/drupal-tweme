<?php

/**
 * @file
 * Provides preprocess logic and other functionality for theming.
 */

// Includes:
$theme_path = drupal_get_path('theme', 'tweme');
include_once $theme_path . '/includes/menu.inc';

/**
 * Implements hook_theme().
 */
function tweme_theme() {
  return array(
    'brand' => array(
      'file' => 'includes/theme.inc',
      'variables' => array(
        'name' => NULL,
        'href' => NULL,
        'logo' => NULL,
      ),
    ),
    'preface' => array(
      'file' => 'includes/theme.inc',
      'variables' => array(
        'breadcrumb' => NULL,
        'title_prefix' => array(),
        'title' => NULL,
        'title_suffix' => array(),
        'messages' => NULL,
        'help' => array(),
        'tabs' => array(),
        'actions' => array(),
      ),
    ),
    'copyright' => array(
      'file' => 'includes/theme.inc',
      'variables' => array(
        'name' => NULL,
      ),
    ),
    'navbar_toggler' => array(
      'file' => 'includes/theme.inc',
    ),
  );
}

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
  
  // Provide additional variables to theme.
  $vars['brand'] = theme('brand', array(
    'name' => $vars['site_name'],
    'href' => $vars['front_page'],
    'logo' => $vars['logo'],
  ));
  $vars['preface'] = theme('preface', array(
    'breadcrumb' => $vars['breadcrumb'],
    'title_prefix' => $vars['title_prefix'],
    'title' => $vars['title'],
    'title_suffix' => $vars['title_suffix'],
    'messages' => $vars['messages'],
    'help' => $page['help'],
    'tabs' => $vars['tabs'],
    'actions' => $vars['action_links'],
  ));
  $vars['navbar_toggler'] = theme('navbar_toggler');
  $vars['copyright'] = theme('copyright', array('name' => $vars['site_name']));

  // Render navbar menu.
  $vars['navbar_menu'] = drupal_render($vars['navbar_menu_tree']);

  // Render and clean up navbar search form.
  $vars['navbar_search'] = drupal_render($vars['navbar_search_form']);
  $vars['navbar_search'] = strip_tags($vars['navbar_search'], '<form><input>');
  
  if (_tweme_is_tweme()) {
  // Prepare some useful variables.
    $vars['has_header'] = !empty($vars['title']) || !empty($vars['messages']);
    $vars['has_sidebar_first'] = !empty($page['sidebar_first']) || !empty($page['sidebar_first_affix']);
    $vars['has_sidebar_second'] = !empty($page['sidebar_second']) || !empty($page['sidebar_second_affix']);
    $vars['content_cols'] = 12 - 3 * (int) $vars['has_sidebar_first'] - 3 * (int) $vars['has_sidebar_second'];
  }
}

/**
 * Implements hook_preprocess_page().
 */
function tweme_preprocess_page(&$vars) {
  $page = $vars['page'];

  // Prepare navbar menu.
  $vars['navbar_menu_tree'] = menu_tree(variable_get('menu_main_links_source', 'main-menu'));

  // Prepare navbar search form.
  $vars['navbar_search_form'] = FALSE;
  if (module_exists('search')) {
    $form = drupal_get_form('_tweme_search_form');
    $form['#attributes']['class'][] = 'navbar-search';
    $form['#attributes']['class'][] = 'navbar-search-elastic';
    $form['#attributes']['class'][] = 'hidden-phone';
    $vars['navbar_search_form'] = $form;
  }

  // Connect Twitter Bootstrap via Libraries API.
  $loaded = FALSE;
  if (module_exists('libraries')) {
    if (libraries_detect('bootstrap')) {
      // Try to load the library.
      $loaded = libraries_load('bootstrap');
    }
    if (!$loaded) {
      // Otherwise try to load the library manually by path.
      $bootstrap_path = libraries_get_path('bootstrap');
      if ($bootstrap_path) {
        drupal_add_css($bootstrap_path . '/css/bootstrap.css', array('media' => 'all'));
        drupal_add_css($bootstrap_path . '/css/bootstrap-responsive.css', array('media' => 'screen'));
        drupal_add_js($bootstrap_path . '/js/bootstrap.js');
        $loaded = TRUE;
      }
    }
  }
  if (!$loaded) {
    // Notify a user if Bootstrap library was not found.
    drupal_set_message(t('Twitter Bootstrap library was not found. See <a href="http://drupal.org/project/tweme#install" target="_blank">installation guide</a> for more details.'), 'error');
  }

  if (_tweme_is_tweme()) {
    // Affix sidebars.
    $tweme_path = drupal_get_path('theme', 'tweme');
    drupal_add_js($tweme_path . '/assets/js/affix.js');
    // Add custom classes to navbar search form.
    $vars['navbar_search_form']['#attributes']['class'][] = 'pull-right';
  }
}

/**
 * Implements hook_preprocess_block().
 */
function tweme_preprocess_block(&$vars) {
  $block = $vars['block'];

  if ($block->region == 'featured') {
    $vars['classes_array'][] = 'item';
    if ($vars['block_id'] == 1) {
      $vars['classes_array'][] = 'active';
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
  $out = '';
  if (!empty($vars['primary'])) {
    $vars['primary']['#prefix'] = '<ul class="nav nav-tabs">';
    $vars['primary']['#suffix'] = '</ul>';
    $out .= drupal_render($vars['primary']);
  }
  if (!empty($vars['secondary'])) {
    $vars['secondary']['#prefix'] = '<ul class="nav nav-pills">';
    $vars['secondary']['#suffix'] = '</ul>';
    $out .= drupal_render($vars['secondary']);
  }
  return $out;
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
function _tweme_search_form($form, &$form_state) {
  $form = search_form($form, $form_state);

  // Set additional attributes.
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
