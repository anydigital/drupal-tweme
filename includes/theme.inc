<?php

/**
 * @file
 * Provides custom theme overrides and implementations.
 */

/**
 * Implements theme_brand().
 */
function tweme_brand($vars) {
  $out = '<a class="brand" href="' . $vars['href'] . '">';
  if ($vars['logo']) {
    $out .= '<img src="' . $vars['logo'] . '" /> ';
  }
  $out .= $vars['name'];
  $out .= '</a>';
  return $out;
}

/**
 * Implements theme_brand().
 */
function tweme_copyright($vars) {
  return date('Y') . ' &copy; ' . $vars['name'];
}

/**
 * Implements theme_preface().
 */
function tweme_preface($vars) {
  $out = '';
  $out .= drupal_render($vars['title_prefix']);
  $out .= $vars['breadcrumb'];
  if ($vars['title']) {
    $out .= '<h1>' . $vars['title'] . '</h1>';
  }
  $out .= drupal_render($vars['title_suffix']);
  $out .= $vars['messages'];
  $out .= drupal_render($vars['help']);
  $out .= drupal_render($vars['tabs']);
  if ($vars['actions']) {
    $out .= '<ul class="action-links">';
    $out .= drupal_render($vars['actions']);
    $out .= '</ul>';
  }
  return $out;
}

/**
 * Implements theme_navbar_toggler().
 */
function tweme_navbar_toggler($vars) {
  $out = '<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">';
  $out .= '<span class="icon-bar"></span>';
  $out .= '<span class="icon-bar"></span>';
  $out .= '<span class="icon-bar"></span>';
  $out .= '</button>';
  return $out;
}
