<?php

/**
 * @file
 * Provides functions for loading libraries.
 */

/**
 * Connects jQuery library.
 */
function _tweme_load_jquery() {
  _tweme_verify_jquery_update();
}

/**
 * Connects Twitter Bootstrap library.
 */
function _tweme_load_bootstrap() {
  if ($bootstrap_path = _tweme_detect_twitter_bootstrap()) {
    drupal_add_css($bootstrap_path . '/css/bootstrap.css', array('media' => 'all'));
    drupal_add_css($bootstrap_path . '/css/bootstrap-responsive.css', array('media' => 'screen', 'browsers' => array('IE' => 'gte IE 9', '!IE' => TRUE), 'preprocess' => FALSE));
    drupal_add_js($bootstrap_path . '/js/bootstrap.js');
  }
}

/**
  * Verifies if jQuery Update is properly installed and configured.
  */
function _tweme_verify_jquery_update() {
  if (!module_exists('jquery_update')) {
    _tweme_admin_message(t('<a href="http://drupal.org/project/jquery_update" target="_blank">jQuery Update</a> module is not installed.'), 'error');
    return;
  }
  $version = variable_get('jquery_update_jquery_version');
  if ($version != '1.7') {
    _tweme_admin_message(t('You are now using jQuery @version. Recommended version: jQuery 1.7. <a href="@config">Configure</a>.', array('@version' => $version, '@config' => url('admin/config/development/jquery_update'))), 'warning');
  }
}

/**
  * Detects where Twitter Bootstrap library is located.
  */
function _tweme_detect_twitter_bootstrap() {
  if (module_exists('libraries')) {
    $path = libraries_get_path('bootstrap');
    if (_tweme_check_twitter_bootstrap_path($path)) {
      return $path;
    }
  }
  $path = 'sites/all/libraries/bootstrap';
  if (_tweme_check_twitter_bootstrap_path($path)) {
    return $path;
  }
  _tweme_admin_message(t('<a href="http://getbootstrap.com" target="_blank">Twitter Bootstrap</a> library was not found. Download and extract it here: <code>sites/all/libraries/bootstrap</code>.'), 'error');
  return FALSE;
}

/**
  * Checks Twitter Bootstrap library path.
  */
function _tweme_check_twitter_bootstrap_path($path) {
  return isset($path) && is_dir(DRUPAL_ROOT . '/' . $path) && file_exists(DRUPAL_ROOT . '/' . $path . '/css/bootstrap.css');
}
