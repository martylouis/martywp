<?php
/**
 * Utility functions
 */
function is_element_empty($element) {
  $element = trim($element);
  return !empty($element);
}

// Tell WordPress to use searchform.php from the templates/ directory
function base_get_search_form() {
  $form = '';
  locate_template('/parts/form-search.php', true, false);
  return $form;
}
add_filter('get_search_form', 'base_get_search_form');

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
 * Debug code in Javascript console
 */
function console_debug($data, $type = 'table') {
  if(is_array($data) || is_object($data)) :
      echo("<script>console." . $type . "(".json_encode($data).");</script>");
  else :
    echo("<script>console." . $type . "(".$data.");</script>");
  endif;
}

/*
 * Sanitize Phone numbers
 */
function _base_sanitize_phone($phone) {
  $san_phone = preg_replace("/[^0-9]/","",esc_attr( $phone ));
  return $san_phone;
}
