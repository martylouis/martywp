<?php

/**
 * Add page slug to body_class() classes if it doesn't exist
 */
function _base_body_class($classes) {
  // Add post/page slug
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }
  return $classes;
}
add_filter('body_class', '_base_body_class');



/**
  * Tell WordPress to use searchform.php from the parts directory
  */
function _base_get_search_form() {
  $form = '';
  locate_template('/parts/form-search.php', true, false);
  return $form;
}
add_filter('get_search_form', '_base_get_search_form');


/**
 * Clean up the_excerpt()
 */
function _base_excerpt_more() {
  return sprintf(__(' &hellip; <div class="post-read-more"><a href="%s">Read More &rarr;</a></div>'), get_permalink());
}
add_filter('excerpt_more', '_base_excerpt_more');



/**
 * Update the_excerpt() lenth
 */
function _base_excerpt_length($length) {
  return 40;
}
add_filter('excerpt_length', '_base_excerpt_length', 999);



/**
 * Modify Archive/Category Titles
 */
function _base_archive_title($title) {
  if (is_category()) {
    $title = single_cat_title('', false);
  } elseif (is_tag()) {
    $title = single_tag_title('', false);
  } elseif (is_author()) {
    $title = sprintf(__('<span class="author">Posts by %s</span>', '_base'), get_the_author());
  } elseif (is_post_type_archive()) {
    $title = post_type_archive_title('', false);
  } elseif (is_tax()) {
    $title = single_term_title('', false);
  }

  return $title;
}
add_filter('get_the_archive_title', '_base_archive_title');
