<?php

/**
 * @file
 * Provides theme overrides and implementations for the Node module.
 */

/**
 * Processes variables for node.tpl.php.
 */
function tweme_process_node(&$vars) {
  list($vars['title'], ) = _tweme_parse_title($vars['title']);
}
