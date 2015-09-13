<?php

/**
 * Implements hook_html_head_alter().
 */
function tweme_html_head_alter(&$head_elements) {
  foreach ($head_elements as &$element) {
    if (isset($element['#attributes']['rel'])
        && in_array($element['#attributes']['rel'], array('canonical', 'shortlink'))
        && drupal_is_front_page()) {
      $element['#attributes']['href'] = '/';
    }
  }
}

/**
 * Implements hook_css_alter().
 */
function tweme_css_alter(&$css) {
  unset($css['modules/poll/poll.css']);

  // Less fallback:
  if (!module_exists('less')) {
    foreach ($css as &$file) {
      if ($file['type'] == 'file' && substr($file['data'], -5) == '.less') {
        $file['data'] = substr($file['data'], 0, -5) . '.css';
      }
    }
  }
}

/**
 * Preprocesses variables for page.tpl.php.
 */
function tweme_preprocess_page(&$vars) {
  $vars['header_attributes'] = '';
  $page = &$vars['page'];

  if ($page['header_bg']) {
    $children = element_children($page['header_bg']);
    $delta = reset($children);
    $block = $page['header_bg'][$delta]['#block'];
    if ($block->region == 'header_bg' && $block->module == 'imageblock' && module_exists('imageblock')) {
      if ($img = imageblock_get_file($block->delta)) {
        $src = file_create_url($img->uri);
        $vars['header_attributes'] = sprintf(' style="background-image: url(%s)"', $src);
      }
    }
  }
}

/**
 * Processes variables for page.tpl.php.
 */
function tweme_process_page(&$vars) {
  $page = &$vars['page'];

  if ($vars['is_front'] && !$vars['title']) {
    $vars['title'] = $vars['site_name'];
  }
}

/**
 * Preprocesses variables for region.tpl.php.
 */
function tweme_preprocess_region(&$vars) {
  $vars['block_count'] = count(element_children($vars['elements']));
}

/**
 * Preprocesses variables for block.tpl.php.
 */
function tweme_preprocess_block(&$vars) {
  $block = &$vars['block'];

  if ($block->region == 'header' && $block->module == 'imageblock' && module_exists('imageblock')) {
    if ($img = imageblock_get_file($block->delta)) {
      $src = file_create_url($img->uri);
      $vars['attributes_array']['style'] = sprintf('background-image: url(%s)', $src);
    }
  }
  if ($block->region == 'footer' && $block->module == 'menu' && $block->delta == 'menu-footer-sitemap') {
    $vars['classes_array'][] = 'row';
  }
}

/**
 * Overrides theme_menu_tree() for menu_footer_sitemap.
 */
function tweme_menu_tree__menu_footer_sitemap($vars) {
  return '<ul class="list-unstyled">' . $vars['tree'] . '</ul>';
}

/**
 * Overrides theme_menu_link() for menu_footer_sitemap.
 */
function tweme_menu_link__menu_footer_sitemap($vars) {
  $element = $vars['element'];

  $sub_menu = $element['#below'] ? drupal_render($element['#below']) : '';
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);

  if ($element['#original_link']['depth'] == 1) {
    $element['#attributes']['class'][] = 'root col-xs-6 col-sm-4 col-md-2';
  }
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

/**
 * Overrides theme_system_powered_by().
 */
function tweme_system_powered_by() {
  return '© ' . date('Y') . ' <a href="' . base_path() . '">' . variable_get('site_name') . '</a>. ' .
    theme_system_powered_by() .
    (module_exists('atoms') ? ', <a href="http://drupal.tonystar.me/atoms">Atoms</a>' : '') .
    ' ' . t('and') . ' <a href="http://drupal.tonystar.me/tweme">Tweme</a>.';
}

/**
 * Preprocesses variables for poll-bar.tpl.php.
 */
function tweme_preprocess_poll_bar(&$vars) {
  $vars['theme_hook_suggestions'] = array('poll_bar');
}

/**
 * Preprocesses variables for theme_item_list().
 */
function tweme_preprocess_item_list(&$vars) {
  $vars['attributes']['class'][] = 'list-unstyled';
}

/**
 * Preprocesses variables for theme_links().
 */
function tweme_preprocess_links(&$vars) {
  $vars['attributes']['class'][] = 'list-unstyled';
}
