<?php

/**
 * @file
 * Theme setting callbacks for the Tweme theme.
 */

/**
 * Implements hook_form_FORM_ID_alter() for system_theme_settings.
 */
function tweme_form_system_theme_settings_alter(&$form, &$form_state) {
  $form['libraries'] = array(
    '#type' => 'fieldset',
    '#title' => t('Libraries'),
    'jquery_source' => array(
      '#type' => 'radios',
      '#title' => t('Load jQuery library from:'),
      '#options' => array(
        'googlecdn' => t('Google CDN'),
        'libraries' => t('sites/all/libraries/jquery'),
        'drupal' => t('Provided by Drupal'),
      ),
      '#default_value' => theme_get_setting('jquery_source'),
    ),
    'jquery_version' => array(
      '#type' => 'textfield',
      '#title' => t('jQuery version:'),
      '#default_value' => theme_get_setting('jquery_version'),
    ),
    'bootstrap_source' => array(
      '#type' => 'radios',
      '#title' => t('Load Twitter Bootstrap library from:'),
      '#options' => array(
        'bootstrapcdn' => t('Bootstrap CDN'),
        'libraries' => t('sites/all/libraries/bootstrap'),
        'theme' => t('[current_theme]/libraries/bootstrap'),
      ),
      '#default_value' => theme_get_setting('bootstrap_source'),
    ),
    'bootstrap_version' => array(
      '#type' => 'textfield',
      '#title' => t('Twitter Bootstrap version:'),
      '#default_value' => theme_get_setting('bootstrap_version'),
    ),
  );
}
