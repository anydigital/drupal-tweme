<?php

/**
 * @file
 * Provides theme overrides and implementations for the Poll module.
 */

/**
 * Preprocesses variables for poll_bar.tpl.php.
 */
function tweme_preprocess_poll_bar(&$vars) {
  $vars['theme_hook_suggestions'] = array('poll_bar');
}
