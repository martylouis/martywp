<?php

/**
 * Debug code in Javascript console
 */
function console_debug($data, $type = 'table') {
  if( is_array($data) || is_object($data) ) :
    echo '<script>console.' . $type . '('. json_encode($data) .')</script>';
  else :
    echo '<script>console.' . $type . '("' . $data. '");</script>';
  endif;
}


/**
 * Is the element empty?
 */
function is_element_empty($element) {
  $element = trim($element);
  return !empty($element);
}


/*
 * Sanitize Phone numbers
 */
function _base_sanitize_phone($phone) {
  $san_phone = preg_replace("/[^0-9]/","",esc_attr( $phone ));
  return $san_phone;
}


/**
 * Page titles
 */
function _base_title() {
  if (is_home()) {
    if (get_option('page_for_posts', true)) {
      return get_the_title(get_option('page_for_posts', true));
    } else {
      return __('Latest Posts', '_base');
    }
  } elseif (is_archive()) {
    return get_the_archive_title();
  } elseif (is_search()) {
    return sprintf(__('Search Results for %s', '_base'), get_search_query());
  } elseif (is_404()) {
    return __('Not Found', '_base');
  } else {
    return get_the_title();
  }
}