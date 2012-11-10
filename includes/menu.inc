<?php

/**
 * @file
 * Provides menu-related theme overrides and implementations.
 */

/**
 * Implements theme_menu_tree().
 */
function tweme_menu_tree__main_menu($vars) {
  return '<ul class="nav">' . $vars['tree'] . '</ul>';
}

/**
 * Implements theme_menu_link().
 */
function tweme_menu_link__main_menu($vars) {
  $elem = $vars['element'];

  // Rewrite the link output in special cases.
  if ($elem['#title'] == '---') {
    return '<li class="divider"></li>';
  }
  if ($elem['#title'][0] == '#') {
    return '<li class="nav-header">' . trim(drupal_substr($elem['#title'], 1)) . '</li>';
  }

  // Initialize variables.
  $link = $elem['#original_link'];
  $li_attrs = array();
  $a_attrs = array();

  // Mark link as active.
  if ($link['in_active_trail']) {
    $li_attrs['class'][] = 'active';
  }

  // Build submenu.
  $sub_menu = '';
  if ($link['has_children'] && $link['expanded']) {
    if ($link['depth'] == 1) {
      $li_attrs['class'][] = 'dropdown';
      $a_attrs['class'][] = 'dropdown-toggle';
      $a_attrs['data-toggle'][] = 'dropdown';
      $a_attrs['data-target'][] = '#';
      $elem['#title'] .= ' <b class="caret"></b>';
    }
    elseif ($link['depth'] > 1) {
      $li_attrs['class'][] = 'dropdown-submenu';
    }
    unset($elem['#below']['#theme_wrappers']);
    $sub_menu = '<ul class="dropdown-menu">' . drupal_render($elem['#below']) . '</ul>';
  }

  // Build link output.
  $out = '';
  $out .= '<li' . drupal_attributes($li_attrs) . '>';
  $out .= l($elem['#title'], $elem['#href'], array('attributes' => $a_attrs, 'html' => TRUE));
  $out .= $sub_menu;
  $out .= '</li>';

  return $out;
}
