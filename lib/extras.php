<?php
/**
 * Clean up the_excerpt()
 */
function _base_excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', '_base') . '</a>';
}
add_filter('excerpt_more', '_base_excerpt_more');
