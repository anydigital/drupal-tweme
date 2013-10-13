<?php

/**
 * @file
 * Default theme implementation to display a preface for the current page.
 */

print $breadcrumb;
print render($title_prefix);
if ($title) {
  print '<h1>' . $title . ($subtitle ? ' <small>' . $subtitle . '</small>' : '') . '</h1>';
}
print render($title_suffix);
print render($help);
print render($tabs);
if ($actions) {
  print '<ul class="action-links">' . render($actions) . '</ul>';
}
