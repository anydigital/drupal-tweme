<?php

/**
 * @file
 * Provides preprocess logic and other functionality for theming.
 */

// Ensure that __DIR__ constant is defined:
if (!defined('__DIR__')) {
  define('__DIR__', dirname(__FILE__));
}

// Require files:
require_once __DIR__ . '/includes/helpers.inc';
require_once __DIR__ . '/includes/menus.inc';
require_once __DIR__ . '/includes/theme.inc';

// Require module specific files:
$requires = file_scan_directory(__DIR__ . '/includes/modules', '/\.inc$/');
foreach ($requires as $require) {
  if (module_exists($require->name)) {
    require_once $require->uri;
  }
}

/**
 * Implements hook_theme().
 */
function tweme_theme($existing, $type, $theme, $path) {
  return array(
    'navbar_brand' => array(
      'variables' => array(
        'name' => NULL,
        'href' => NULL,
        'logo' => NULL,
      ),
    ),
    'navbar_toggler' => array(),
    'preface' => array(
      'path' => $path . '/templates',
      'template' => 'preface',
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
      'variables' => array(
        'name' => NULL,
      ),
    ),
    'pure_form_wrapper' => array(
      'render element' => 'element',
    ),
    'search_input_wrapper' => array(
      'render element' => 'element',
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
 * Implements hook_process_html().
 */
function tweme_process_html(&$vars) {
  if ($body_top = _tweme_region_blocks_markup('body_top')) {
    $vars['page_top'] = '<div class="conceal">' . $body_top . '</div>' . $vars['page_top'];
  }
  if ($body_bottom = _tweme_region_blocks_markup('body_bottom')) {
    $vars['page_bottom'] .= '<div class="conceal">' . $body_bottom . '</div>';
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
    $form = drupal_get_form('search_form');
    unset($form['basic']['keys']['#theme_wrappers']);
    $form['basic']['keys']['#attributes']['class'][] = 'search-query';
    $form['#attributes']['class'][] = 'navbar-search';
    $form['#attributes']['class'][] = 'navbar-search-elastic';
    $form['#attributes']['class'][] = 'hidden-phone';
    $form['#theme_wrappers'][] = 'pure_form_wrapper';
    $vars['navbar_search_form'] = $form;
  }

  // Verify jQuery Update:
  _tweme_verify_jquery_update();

  // Connect Twitter Bootstrap library:
  if ($bootstrap_path = _tweme_detect_twitter_bootstrap()) {
    drupal_add_css($bootstrap_path . '/css/bootstrap.css', array('media' => 'all'));
    drupal_add_css($bootstrap_path . '/css/bootstrap-responsive.css', array('media' => 'screen', 'browsers' => array('IE' => 'gte IE 9', '!IE' => TRUE), 'preprocess' => FALSE));
    drupal_add_js($bootstrap_path . '/js/bootstrap.js');
  }

  if (_tweme_is_tweme()) {
    // Add custom classes to navbar search form.
    $vars['navbar_search_form']['#attributes']['class'][] = 'pull-right';
  }
}

/**
 * Implements hook_process_page().
 */
function tweme_process_page(&$vars) {
  $page = $vars['page'];
  
  // Provide additional variables to theme.
  $vars['navbar_brand'] = theme('navbar_brand', array(
    'name' => $vars['site_name'],
    'href' => $vars['front_page'],
    'logo' => $vars['logo'],
  ));
  $vars['navbar_menu'] = drupal_render($vars['navbar_menu_tree']);
  $vars['navbar_search'] = drupal_render($vars['navbar_search_form']);
  $vars['navbar_toggler'] = theme('navbar_toggler');
  $vars['preface'] = theme('preface', $vars);
  $vars['copyright'] = theme('copyright', array('name' => $vars['site_name']));

  if (_tweme_is_tweme()) {
  // Prepare some useful variables.
    $vars['has_header'] = !empty($vars['title']) || !empty($vars['messages']);
    $vars['has_sidebar_first'] = !empty($page['sidebar_first']) || !empty($page['sidebar_first_affix']);
    $vars['has_sidebar_second'] = !empty($page['sidebar_second']) || !empty($page['sidebar_second_affix']);
    $vars['content_cols'] = 12 - 3 * (int) $vars['has_sidebar_first'] - 3 * (int) $vars['has_sidebar_second'];
  }
}

/**
 * Processes variables for node.tpl.php.
 */
function tweme_process_node(&$vars) {
  list($vars['title'], ) = _tweme_parse_title($vars['title']);
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
 * Implements hook_preprocess_menu_local_tasks().
 */
function tweme_preprocess_menu_local_tasks(&$vars) {
  $vars['primary_widget'] = 'tabs';
  $vars['secondary_widget'] = 'pills';
}

/**
 * Helper function: returns TRUE if current theme is Tweme.
 */
function _tweme_is_tweme() {
  global $theme;
  return $theme == 'tweme';
}

/**
  * Helper function: returns markup of all blocks in the region.
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

/**
  * Helper function: verifies if jQuery Update is properly installed and configured.
  */
function _tweme_verify_jquery_update() {
  if (!module_exists('jquery_update')) {
    _tweme_admin_message(t('<a href="http://drupal.org/project/jquery_update" target="_blank">jQuery Update</a> module is not installed.'), 'error');
    return;
  }
  $version = variable_get('jquery_update_jquery_version');
  if ($version != '1.7') {
    _tweme_admin_message(t('You are now using jQuery @version. Recommended version: jQuery 1.7. <a href="@config">Configure</a>.', array('@version' => $version, '@config' => url('admin/config/development/jquery_update'))), 'warning');
  }
}

/**
  * Helper function: detects where Twitter Bootstrap library is located.
  */
function _tweme_detect_twitter_bootstrap() {
  if (module_exists('libraries')) {
    $path = libraries_get_path('bootstrap');
    if (_tweme_check_twitter_bootstrap_path($path)) {
      return $path;
    }
  }
  $path = 'sites/all/libraries/bootstrap';
  if (_tweme_check_twitter_bootstrap_path($path)) {
    return $path;
  }
  _tweme_admin_message(t('<a href="http://getbootstrap.com" target="_blank">Twitter Bootstrap</a> library was not found. Download and extract it here: <code>sites/all/libraries/bootstrap</code>.'), 'error');
  return FALSE;
}

/**
  * Helper function: checks Twitter Bootstrap library path.
  */
function _tweme_check_twitter_bootstrap_path($path) {
  return isset($path) && is_dir(DRUPAL_ROOT . '/' . $path) && file_exists(DRUPAL_ROOT . '/' . $path . '/css/bootstrap.css');
}

/**
  * Helper function: displays message for admin.
  */
function _tweme_admin_message($message, $type = 'status') {
  if (user_access('administer')) {
    drupal_set_message('Tweme: ' . $message, $type);
  }
}
