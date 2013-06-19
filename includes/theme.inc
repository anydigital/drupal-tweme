<?php

/**
 * @file
 * Provides custom theme overrides and implementations.
 */

/**
 * Processes variables for preface.tpl.php.
 */
function tweme_process_preface(&$vars) {
  list($vars['title'], $vars['subtitle']) = _tweme_parse_title($vars['title']);
}

/**
 * Returns HTML for the navbar brand.
 */
function tweme_navbar_brand($vars) {
  $out = '<a class="brand" href="' . $vars['href'] . '">';
  if ($vars['logo']) {
    $out .= '<img src="' . $vars['logo'] . '" /> ';
  }
  $out .= $vars['name'];
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
