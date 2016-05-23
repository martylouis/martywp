<?php
/**
 * Post Types includes
 *
 * All custom post types added to this theme
 *
 * @link https://github.com/roots/roots/pull/1042
 */
$post_types = array(
  // 'post-types/post-type.php',
);

foreach ($post_types as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', '_base'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);
