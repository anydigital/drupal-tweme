<?php

/**
 * @file
 * Provides custom theme overrides and implementations.
 */

/**
 * Processes variables for theme_page_headline().
 */
function tweme_process_page_headline(&$vars) {
  list($vars['title'], $vars['subtitle']) = _tweme_parse_title($vars['title']);
}

/**
 * Returns HTML for the page breadcrumbs and title.
 */
function tweme_page_headline($vars) {
  $out = $vars['breadcrumb'];
  $out .= render($vars['title_prefix']);
  if ($vars['subtitle']) {
    $vars['title'] .= ' <small>' . $vars['subtitle'] . '</small>';
  }
  if ($vars['title']) {
    $out .= '<h1>' . $vars['title'] . '</h1>';
  }
  $out .= render($vars['title_suffix']);
  return $out;
}

/**
 * Returns HTML for the messages, tabs and actions.
 */
function tweme_page_controls($vars) {
  $out = render($vars['tabs']);
  if ($vars['actions']) {
    $out .= '<ul class="action-links">' . render($vars['actions']) . '</ul>';
  }
  return $out;
}

/**
 * Returns HTML for the navbar brand.
 */
function tweme_navbar_brand($vars) {
  $out = '<a class="brand" href="' . $vars['href'] . '">';
  if ($vars['logo']) {
    $out .= '<img src="' . $vars['logo'] . '" /> ';
  }
  $out .= '<span>' . $vars['name'] . '</span>';
  $out .= '</a>';
  return $out;
}

/**
 * Overrides theme_menu_link().
 */
function tweme_menu_link($vars) {
  if ($vars['element']['#original_link']['menu_name'] == _tweme_primary_menu_name()) {
    return tweme_navbar_menu_link($vars);
  }
  else {
    return theme_menu_link($vars);
  }
}

/**
 * Returns HTML for the navbar menu link.
 */
function tweme_navbar_menu_link($vars) {
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

/**
 * Returns HTML for the navbar toggler.
 */
function tweme_navbar_toggler($vars) {
  $out = '<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">';
  $out .= '<span class="icon-bar"></span>';
  $out .= '<span class="icon-bar"></span>';
  $out .= '<span class="icon-bar"></span>';
  $out .= '</button>';
  return $out;
}

/**
 * Returns HTML for the copyright text.
 */
function tweme_copyright($vars) {
  return t('Copyright &copy; @year @name. All rights reserved.', array(
    '@year' => date('Y'),
    '@name' => $vars['name']));
}

/**
 * Cleans up form markup leaving only <form> and <input> tags.
 */
function tweme_pure_form_wrapper($vars) {
  return strip_tags($vars['element']['#children'], '<form><input>');
}
