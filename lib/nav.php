<?php

namespace martywp;

use martywp\utils;

class Nav {

  function __construct() {

    add_filter('nav_menu_item_id', '__return_null');
    add_filter('nav_menu_css_class', [$this, 'nav_classes'], 10, 4);
    add_filter('wp_nav_menu_args', [$this, 'nav_args']);

  }

  /**
   * Remove the id="" on nav menu items
   * Return 'menu-slug' for nav menu classes
   */
  function nav_classes($classes, $item, $args, $depth) {
    // $slug = sanitize_title($item->title);
    $classes = preg_replace('/(current(-menu-|[-_]page[-_])(item|parent))/', 'nav__item--active', $classes);
    $classes = preg_replace('/^((menu|page)[-_\w+]+)+/', '', $classes);

    if ($item->menu_item_parent > 0 ) {
      $classes[] = 'nav__item nav--dropdown__item';
    } else {
      $classes[] = 'nav__item';
    }

    $classes = array_unique($classes);
    return array_filter($classes, [$this, 'is_element_empty']);
  }

  /**
   * Clean up wp_nav_menu_args
   *
   * Remove the container
   * Use _Base_Nav_Walker() by default
   */
  function nav_args($args = '') {
    $nav_args = [];

    $nav_args['container'] = false;

    if (!$args['items_wrap']) {
      $nav_args['items_wrap'] = '<ul class="%2$s">%3$s</ul>';
    }

    if (!$args['depth']) {
      $nav_args['depth'] = 2;
    }

    return array_merge($args, $nav_args);
  }

  /**
   * Is the element empty?
   */

  function is_element_empty($element) {
    $element = trim($element);
    return !empty($element);
  }

}

new Nav;
