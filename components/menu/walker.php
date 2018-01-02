<?php

// namespace MartyWP\Components\Menu;

use MartyWP\Lib\Utils;

/**
 * Cleaner walker for wp_nav_menu()
 *
 * Walker_Nav_Menu (WordPress default) example output:
 *   <li id="menu-item-8" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8"><a href="/">Home</a></li>
 *   <li id="menu-item-9" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-9"><a href="/sample-page/">Sample Page</a></l
 *
 * Example output:
 *   <li class="menu-home"><a href="/">Home</a></li>
 *   <li class="menu-sample-page"><a href="/sample-page/">Sample Page</a></li>
 */
class MartyWP_Walker extends Walker_Nav_Menu {
  function check_current($classes) {
    return preg_match('/(current[-_])|active|dropdown/', $classes);
  }

  function start_lvl(&$output, $depth = 0, $args = array()) {
    $output .= "\n<ul class=\"sub-menu dropdown-menu\">\n";
  }

  function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
    $item_html = '';
    parent::start_el($item_html, $item, $depth, $args);

    $item_html = str_replace('<a', '<a class="nav-link"', $item_html);

    if ($item->is_dropdown && ($depth === 0)) {
      $item_html = str_replace('</a>', '</a><a type="button" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="sr-only">Toggle Dropdown</span></a>', $item_html);
    }
    elseif (stristr($item_html, 'li class="has-button')) {
      $item_html = str_replace('<a', '<a class="nav-link nav-btn btn"', $item_html);
    }
    elseif (stristr($item_html, 'li class="divider')) {
      $item_html = preg_replace('/<a[^>]*>.*?<\/a>/iU', '', $item_html);
    }
    elseif (stristr($item_html, 'li class="dropdown-header')) {
      $item_html = preg_replace('/<a[^>]*>(.*)<\/a>/iU', '$1', $item_html);
    }

    $item_html = apply_filters('_base/wp_nav_menu_item', $item_html);
    $output .= $item_html;
  }

  function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
    $element->is_dropdown = ((!empty($children_elements[$element->ID]) && (($depth + 1) < $max_depth || ($max_depth === 0))));

    if ($element->is_dropdown) {
      $element->classes[] = 'dropdown';
    }

    parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
  }
}

/**
 * Is the element empty?
 */

function is_element_empty($element) {
  $element = trim($element);
  return !empty($element);
}

/**
 * Remove the id="" on nav menu items
 * Return 'menu-slug' for nav menu classes
 */
function _base_nav_menu_css_class($classes, $item, $args, $depth) {
  $slug = sanitize_title($item->title);
  $classes = preg_replace('/(current(-menu-|[-_]page[-_]))/', 'active-', $classes);
  $classes = preg_replace('/^((menu|page)[-_\w+]+)+/', '', $classes);

  if ($item->menu_item_parent > 0 ) {
    $classes[] = 'sub-menu-item nav-item menu-' . $slug;
  } else {
    $classes[] = 'nav-item menu-' . $slug;
  }

  $classes = array_unique($classes);
  return array_filter($classes, 'is_element_empty');
}
add_filter('nav_menu_css_class', '_base_nav_menu_css_class', 10, 4);
add_filter('nav_menu_item_id', '__return_null');

/**
 * Clean up wp_nav_menu_args
 *
 * Remove the container
 * Use _Base_Nav_Walker() by default
 */
function _base_nav_menu_args($args = '') {
  $_base_nav_menu_args = array();

  $_base_nav_menu_args['container'] = false;

  if (!$args['items_wrap']) {
    $_base_nav_menu_args['items_wrap'] = '<ul class="%2$s">%3$s</ul>';
  }

  if (!$args['depth']) {
    $_base_nav_menu_args['depth'] = 2;
  }

  return array_merge($args, $_base_nav_menu_args);
}
add_filter('wp_nav_menu_args', '_base_nav_menu_args');
