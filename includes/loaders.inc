<?php

/**
 * @file
 * Provides functions for loading libraries.
 */

/**
 * Loads Twitter Bootstrap library.
 */
function _tweme_load_bootstrap() {
  $version = theme_get_setting('bootstrap_version');
  $js_path = '/js/bootstrap.min.js';
  $js_options = array(
    'group' => JS_LIBRARY,
  );
  $css_path = '/css/bootstrap.min.css';
  $cssr_path = '/css/bootstrap-responsive.min.css';
  $css_options = array(
    'group' => CSS_THEME,
    'weight' => -1000,
    'every_page' => TRUE,
  );
  switch (theme_get_setting('bootstrap_source')) {
    case 'bootstrapcdn':
      $bootstrap_path = '//netdna.bootstrapcdn.com/twitter-bootstrap/' . $version;
      $js_options['type'] = 'external';
      $css_path = '/css/bootstrap-combined.min.css';
      unset($cssr_path);
      $css_options['type'] = 'external';
      break;
    case 'libraries':
      $bootstrap_path = 'sites/all/libraries/bootstrap';
      break;
    case 'theme';
      $bootstrap_path = path_to_theme() . '/libraries/bootstrap';
      break;
    default:
      return;
  }
  _tweme_add_asset('js', $bootstrap_path . $js_path, $js_options);
  _tweme_add_asset('css', $bootstrap_path . $css_path, $css_options);
  if (isset($cssr_path)) {
    _tweme_add_asset('css', $bootstrap_path . $cssr_path, $css_options);
  }
}

/**
 * Loads HTML5 Shiv library.
 */
function _tweme_load_html5shiv() {
  _tweme_add_asset(
    'js', '//html5shiv.googlecode.com/svn/trunk/html5.js',
    array('browsers' => 'obsolete'));
}

/**
 * Loads assets.
 */
function _tweme_load_assets() {
  $assets_dir = drupal_get_path('theme', 'tweme') . '/assets';
  
  if (theme_get_setting('max_width_940')) {
    _tweme_add_asset(
      'css', $assets_dir . '/css/max-width-940.css',
      array(
        'group' => CSS_THEME,
        'browsers' => 'modern',
        'media' => 'screen',
      ));
    _tweme_add_asset(
      'js', $assets_dir . '/js/max-width-940.js',
      array('browsers' => 'modern'));
  }
  if (theme_get_setting('affixed_sidebars')) {
    _tweme_add_asset(
      'js', $assets_dir . '/js/affixed-sidebars.js',
      array('browsers' => 'modern'));
  }
}
