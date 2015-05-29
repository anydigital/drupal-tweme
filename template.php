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
 * Preprocesses variables for block.tpl.php.
 */
function tweme_preprocess_block(&$vars) {
  $block = $vars['block'];

  if ($block->region == 'header' && $block->module == 'imageblock' && module_exists('imageblock')) {
    if ($img = imageblock_get_file($block->delta)) {
      $src = file_create_url($img->uri);
      $vars['attributes_array']['style'] = sprintf('background-image: url(%s)', $src);
    }
  }
  elseif ($block->region == 'footer' && $block->module == 'menu' && $block->delta == 'menu-footer-sitemap') {
    $vars['classes_array'][] = 'row';
  }
}

/**
 * Preprocesses variables for entity.tpl.php.
 */
function tweme_preprocess_entity(&$vars) {
  $element = $vars['elements'];

  if ($element['#entity_type'] == 'atom') {
    if (!empty($element['#host_field']) && $element['#host_field'] == 'field_featured' && $element['#bundle'] == 'container') {
      $vars['classes_array'][] = 'header-body';
    }
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

function tweme_preprocess_menu_link(&$vars) {
  $element = &$vars['element'];

  if ($element['#original_link']['module'] == 'book') {
    if (!empty($element['#below']) && is_array($element['#below'])) {
      $element['#below']['#theme_wrappers'] = array('menu_tree__book_toc');
      foreach (element_children($element['#below']) as $key) {
        $sub_element = $element['#below'][$key];
        if (!empty($sub_element['#below']) && is_array($sub_element['#below'])) {
          $element['#below']['#suffix'] = drupal_render($sub_element);
          $element['#below'][$key]['#below'] = array();
        }
      }
    }
  }
}

function tweme_menu_link($vars) {
  $element = $vars['element'];

  if ($element['#original_link']['module'] == 'book') {
    return tweme_menu_link__book_toc($vars);
  }
  return bootstrap_menu_link($vars);
}

function tweme_preprocess_book_all_books_block(&$vars) {
  $element = array(
    '#theme' => 'menu_link__book_toc',
    '#original_link' => array(
      'module' => 'book',
    ),
    '#below' => array(),
  );
  foreach ($vars['book_menus'] as $menu) {
    $element['#below'] += $menu;
  }

  $vars['book_menus'] = array(
    array(
      '#prefix' => '<div class="row">',
      '#suffix' => '</div>',
      'element' => $element,
    ),
  );
}

function tweme_menu_tree__book_toc($vars) {
  return '<div class="col-md-4"><ul class="list-unstyled">' . $vars['tree'] . '</ul></div>';
}

function tweme_menu_link__book_toc($vars) {
  $element = $vars['element'];

  if (!empty($element['#below'])) {
    return drupal_render($element['#below']);
  }
  return theme_menu_link($vars);
}

function tweme_preprocess_book_navigation(&$vars) {
  $vars['tree'] = '';
  $vars['has_links'] = FALSE;
}
