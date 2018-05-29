<?php

use martywp\utils;

class NavWalker extends Walker_Nav_Menu {
  function check_current($classes) {
    return preg_match('/(current[-_])|active|dropdown/', $classes);
  }

  function start_lvl(&$output, $depth = 0, $args = array()) {
    $output .= "\n<ul class=\"nav nav--dropdown dropdown-menu\">\n";
  }

  function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
    $item_html = '';
    parent::start_el($item_html, $item, $depth, $args);

    $item_html = str_replace('<a', '<a class="nav__link"', $item_html);

    if ($item->is_dropdown && ($depth === 0)) {
      $item_html = str_replace('<a', '<a class="nav__link nav__link__dropdown--toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"', $item_html);
      $item_html = str_replace('</a>', ' '. Utils::get_svg('caret-down') .'</a>', $item_html);
    }

    if (stristr($item_html, 'li class="has-button')) {
      $item_html = str_replace('<a', '<a class="nav__link nav__link--button"', $item_html);
    }

    if (stristr($item_html, 'li class="nav__item--divider')) {
      $item_html = preg_replace('/<a[^>]*>.*?<\/a>/iU', '', $item_html);
    }

    if (stristr($item_html, 'li class="nav__item--header')) {
      $item_html = preg_replace('/<a[^>]*>(.*)<\/a>/iU', '$1', $item_html);
    }

    $item_html = apply_filters('wp_nav_menu_items', $item_html);
    $output .= $item_html;
  }

  function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
    $element->is_dropdown = ((!empty($children_elements[$element->ID]) && (($depth + 1) < $max_depth || ($max_depth === 0))));

    if ($element->is_dropdown) {
      $element->classes[] = 'nav__item--is-dropdown';
    }

    parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
  }
}

if (has_nav_menu('header_nav')) :
  wp_nav_menu([
    'theme_location' => 'header_nav',
    'menu_id' => false,
    'walker' => new NavWalker(),
    'menu_class' => 'nav', // remove mm-nolistview for muli level menu
  ]);
endif;
