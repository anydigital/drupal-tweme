<?php

/**
 * Implements hook_css_alter().
 */
function tweme_css_alter(&$css) {
  unset($css[drupal_get_path('module', 'poll') . '/poll.css']);
}

/**
 * Implements hook_preprocess_page().
 */
function tweme_preprocess_page(&$vars) {
  $page = $vars['page'];
  $vars['has_sidebar'] = !empty($page['sidebar_first']) || !empty($page['sidebar_second']);

  $main_menu_tree = menu_tree_page_data(variable_get('menu_main_links_source', 'main-menu'));
  $vars['navbar_links'] = _tweme_navbar($main_menu_tree);

  $vars['navbar_search'] = FALSE;
  if (module_exists('search')) {
    $vars['navbar_search'] = _tweme_navbar_search();
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
  $vars['attributes']['class'][] = 'nav nav-tabs nav-stacked';
  return theme_item_list($vars);
}

/**
 * Helper function: returns HTML for a navbar.
 */
function _tweme_navbar($links) {
  $out = '<ul class="nav">';
  foreach ($links as $item) {
    $out .= _tweme_navbar_item($item);
  }
  $out .= '</ul>';
  return $out;
}

/**
 * Helper function: returns HTML for a single navbar item.
 */
function _tweme_navbar_item($item, $level = 0) {
  $link = $item['link'];
  if ($link['hidden']) {
    return '';
  }

  if ($link['title'] == '---') {
    return '<li class="divider"></li>';
  }
  if (strpos($link['title'], '#') === 0) {
    return '<li class="nav-header">' . trim(substr($link['title'], 1)) . '</li>';
  }

  $li_attrs = array();
  if ($link['in_active_trail']) {
    $li_attrs['class'][] = 'active';
  }
  $a_attrs = array();
  $a_title = $link['title'];

  $submenu = '';
  if ($link['has_children'] && $link['expanded']) {
    if ($level == 0) {
      $li_attrs['class'][] = 'dropdown';
      $a_attrs['class'][] = 'dropdown-toggle';
      $a_attrs['data-toggle'][] = 'dropdown';
      $a_attrs['data-target'][] = '#';
      $a_title .= ' <b class="caret"></b>';
    }
    elseif ($level > 0) {
      $li_attrs['class'][] = 'dropdown-submenu';
    }

    $submenu = '<ul class="dropdown-menu">';
    foreach ($item['below'] as $subitem) {
      $submenu .= _tweme_navbar_item($subitem, ++$level);
    }
    $submenu .= '</ul>';
  }

  $out = '<li' . drupal_attributes($li_attrs) . '>';
  $out .= l($a_title, $link['href'], array('attributes' => $a_attrs, 'html' => TRUE));
  $out .= $submenu;
  $out .= '</li>';

  return $out;
}

/**
 * Helper function: returns HTML for a navbar search form.
 */
function _tweme_navbar_search() {
  $form = drupal_get_form('search_form');

  $hidden = array();
  foreach (element_children($form) as $key) {
    $type = $form[$key]['#type'];
    if ($type == 'hidden' || $type == 'token') {
      $hidden[] = drupal_render($form[$key]);
    }
  }

  $out = '<form class="navbar-search navbar-search-elastic pull-left hidden-phone" action="' . $form['#action'] . '">' .
    implode($hidden) .
    '<input name="' . $form['basic']['keys']['#name'] . '" type="text" class="search-query" placeholder="' . t('Search') . '">' .
    '</form>';

  return $out;
}
