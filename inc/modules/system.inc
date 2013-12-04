<?php

/**
 * @file
 * Provides theme overrides and implementations for the System module.
 */

/**
 * Preprocesses variables for html.tpl.php.
 */
function tweme_preprocess_html(&$vars) {
  // Connect Twitter Bootstrap:
  if ($path = theme_get_setting('bootstrap_path')) {
    _tweme_connect_lib('css', $path . '/css/bootstrap.min.css');
    _tweme_connect_lib('css', $path . '/css/bootstrap-responsive.min.css');
    _tweme_connect_lib('js', $path . '/js/bootstrap.min.js');
  }
  // Connect Twitter Bootstrap Extra:
  if ($path = theme_get_setting('bootstrap_extra_path')) {
    _tweme_connect_lib('css', $path . '/css/bootstrap-extra.min.css');
    _tweme_connect_lib('js', $path . '/js/bootstrap-extra.min.js');
  }
  // Connect HTML5 Shiv:
  if ($path = theme_get_setting('html5shiv_path')) {
    _tweme_connect_lib('js', $path . '/html5shiv.min.js', array('browsers' => 'obsolete'));
  }

  if ($max_width = theme_get_setting('max_width')) {
    _tweme_add_asset(
      'css',
      '@media (min-width: 1200px) {
        .container,
        .navbar-static-top .container,
        .navbar-fixed-top .container,
        .navbar-fixed-bottom .container {
          width: ' . $max_width . 'px;
        }
      }',
      array(
        'type' => 'inline',
        'group' => CSS_THEME,
        'browsers' => 'modern',
        'media' => 'screen',
      )
    );
  }
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

  // Prepare navbar menu:
  $vars['navbar_menu_tree'] = menu_tree(_tweme_primary_menu_name());
  unset($vars['navbar_menu_tree']['#theme_wrappers']);

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

  // Pin sidebars:
  if ($vars['page']['sidebar_first_affix']) {
    $vars['page']['sidebar_first_affix']['#prefix'] = '<div data-spy="pin" data-container=".id-pin-to">';
    $vars['page']['sidebar_first_affix']['#suffix'] = '</div>';
  }
  if ($vars['page']['sidebar_second_affix']) {
    $vars['page']['sidebar_second_affix']['#prefix'] = '<div data-spy="pin" data-container=".id-pin-to">';
    $vars['page']['sidebar_second_affix']['#suffix'] = '</div>';
  }
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
  $vars['navbar_menu'] = '<ul class="nav">' . drupal_render($vars['navbar_menu_tree']) . '</ul>';
  $vars['navbar_search'] = drupal_render($vars['navbar_search_form']);
  $vars['navbar_toggler'] = theme('navbar_toggler');
  $vars['headline'] = theme('page_headline', $vars);
  $vars['controls'] = theme('page_controls', $vars);
  $vars['copyright'] = theme('copyright', array('name' => $vars['site_name']));

  // Prepare some useful variables:
  $vars['has_header'] = !(empty($vars['headline']) && empty($vars['messages']) && empty($page['header']) && empty($page['help']) && empty($vars['controls']));
  $vars['has_sidebar_first'] = !(empty($page['sidebar_first']) && empty($page['sidebar_first_affix']));
  $vars['has_sidebar_second'] = !(empty($page['sidebar_second']) && empty($page['sidebar_second_affix']));
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
    return '<div class="pagination">' . theme_item_list($vars) . '</div>';
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
