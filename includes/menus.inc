<?php

/**
 * @file
 * Provides menus related theme overrides and implementations.
 */

/**
 * Overrides theme_menu_tree__MENU_ID() for main menu.
 */
function tweme_menu_tree__main_menu($vars) {
  return '<ul class="nav">' . $vars['tree'] . '</ul>';
}

/**
 * Overrides theme_menu_link__MENU_ID() for main_menu.
 */
function tweme_menu_link__main_menu($vars) {
  $elem = $vars['element'];

  // Prevent XSS exploits:
  $title = check_plain($elem['#title']);

  // Rewrite the link output in special cases:
  if ($title == '---') {
    return '<li class="divider"></li>';
  }
  if ($title[0] == '#') {
    return '<li class="nav-header">' . trim(drupal_substr($title, 1)) . '</li>';
  }

  // Initialize variables:
  $link = $elem['#original_link'];
  $attrs = array();
  $options = $elem['#localized_options'];
  $options['html'] = TRUE;

  // Mark link as active:
  if ($link['in_active_trail']) {
    $attrs['class'][] = 'active';
  }

  // Build submenu:
  $sub_menu = '';
  if ($link['has_children'] && $link['expanded']) {
    if ($link['depth'] == 1) {
      $attrs['class'][] = 'dropdown';
      $options['attributes']['class'][] = 'dropdown-toggle';
      $options['attributes']['data-toggle'][] = 'dropdown';
      $options['attributes']['data-target'][] = '#';
      $title .= ' <b class="caret"></b>';
    }
    elseif ($link['depth'] > 1) {
      $attrs['class'][] = 'dropdown-submenu';
    }
    unset($elem['#below']['#theme_wrappers']);
    $sub_menu = '<ul class="dropdown-menu">' . drupal_render($elem['#below']) . '</ul>';
  }

  // Build link output:
  $out = '<li' . drupal_attributes($attrs) . '>';
  $out .= l($title, $elem['#href'], $options);
  $out .= $sub_menu;
  $out .= '</li>';

  return $out;
}
