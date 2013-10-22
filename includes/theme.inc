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
  return date('Y') . ' &copy; ' . $vars['name'];
}

/**
 * Cleans up form markup leaving only <form> and <input> tags.
 */
function tweme_pure_form_wrapper($vars) {
  return strip_tags($vars['element']['#children'], '<form><input>');
}
