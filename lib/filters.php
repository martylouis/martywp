<?php

/**
 * Add body class if sidebar is active
 */
function _base_sidebar_body_class($classes) {
  if (_base_display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }
  return $classes;
}
add_filter('body_class', '_base_sidebar_body_class');



/**
 * Add page slug to body_class() classes if it doesn't exist
 */
function base_body_class($classes) {
  // Add post/page slug
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }
  return $classes;
}
add_filter('body_class', 'base_body_class');




/**
  * Tell WordPress to use searchform.php from the parts directory
  */
function base_get_search_form() {
  $form = '';
  locate_template('/parts/form-search.php', true, false);
  return $form;
}
add_filter('get_search_form', 'base_get_search_form');


/**
 * Clean up the_excerpt()
 */
function _base_excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', '_base') . '</a>';
}
add_filter('excerpt_more', '_base_excerpt_more');
