<?php

/**
 * @file
 * Provides theme overrides and implementations for the System module.
 */

/**
 * Preprocesses variables for html.tpl.php.
 */
function tweme_preprocess_html(&$vars) {
  _tweme_load_bootstrap();
  _tweme_load_html5shiv();
  _tweme_load_assets();
}

/**
 * Processes variables for html.tpl.php.
 */
function tweme_process_html(&$vars) {
  if ($body_top = _tweme_region_blocks_markup('body_top')) {
    $vars['page_top'] = '<div class="conceal">' . $body_top . '</div>' . $vars['page_top'];
  }
  if ($body_bottom = _tweme_region_blocks_markup('body_bottom')) {
    $vars['page_bottom'] .= '<div class="conceal">' . $body_bottom . '</div>';
  }
  $vars['head_bottom'] = _tweme_add_html_head_bottom();
}

/**
 * Preprocesses variables for page.tpl.php.
 */
function tweme_preprocess_page(&$vars) {
  $page = $vars['page'];

  // Prepare navbar menu:
  $vars['navbar_menu_tree'] = menu_tree(variable_get('menu_main_links_source', 'main-menu'));

  // Prepare navbar search form:
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

  // Add custom classes to navbar search form:
  $vars['navbar_search_form']['#attributes']['class'][] = 'pull-right';
}

/**
 * Processes variables for page.tpl.php.
 */
function tweme_process_page(&$vars) {
  $page = $vars['page'];
  
  // Provide additional variables to theme:
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

  // Prepare some useful variables:
  $vars['has_header'] = !empty($vars['title']) || !empty($vars['messages']);
  $vars['has_sidebar_first'] = !empty($page['sidebar_first']) || !empty($page['sidebar_first_affix']);
  $vars['has_sidebar_second'] = !empty($page['sidebar_second']) || !empty($page['sidebar_second_affix']);
  $vars['content_cols'] = 12 - 3 * (int) $vars['has_sidebar_first'] - 3 * (int) $vars['has_sidebar_second'];
}

/**
 * Overrides theme_menu_local_tasks().
 */
function tweme_menu_local_tasks(&$vars) {
  $out = '';
  if (!empty($vars['primary'])) {
    $vars['primary']['#prefix'] = '<ul class="nav nav-' . theme_get_setting('primary_tasks_style') . '">';
    $vars['primary']['#suffix'] = '</ul>';
    $out .= drupal_render($vars['primary']);
  }
  if (!empty($vars['secondary'])) {
    $vars['secondary']['#prefix'] = '<ul class="nav nav-' . theme_get_setting('secondary_tasks_style') . '">';
    $vars['secondary']['#suffix'] = '</ul>';
    $out .= drupal_render($vars['secondary']);
  }
  return $out;
}

/**
 * Overrides theme_item_list().
 */
function tweme_item_list($vars) {
  if (isset($vars['attributes']['class']) && in_array('pager', $vars['attributes']['class'])) {
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
 * Preprocesses variables for theme_button().
 */
function tweme_preprocess_button(&$vars) {
  $vars['element']['#attributes']['class'][] = 'btn';
  if (isset($vars['element']['#parents'][0]) && $vars['element']['#parents'][0] == 'submit') {
    $vars['element']['#attributes']['class'][] = 'btn-primary';
  }
}
