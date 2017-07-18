<?php

/**
 * Set Working Environment
 */
if (!defined('WP_ENV')) {
  define('WP_ENV', 'production');
}


/**
 * Helper function to pretty up the errors
 */

$base_error_msg = function($message, $subtitle = '', $title = '') {
  $title = $title ?: __('<span style="color:orangered">Error!</span>', '_base');
  $message = "<h1>{$title}</h1><h3>{$subtitle}</span></h3><p>$message</p>";
  wp_die($message, $title);
};

/**
 * _base Required Files
 *
 * The map array determines the code library included in this theme.
 * Add or remove files as needed.
 */
array_map(function($file) use ($base_error_msg) {
  $file = "{$file}.php";
  if (!locate_template($file, true, true)) {
    $base_error_msg(sprintf(__('Error locating <code>%s</code>', '_base'), $file), 'File not found');
  }
}, [
  'lib/helpers',
  'lib/actions',
  'lib/filters',
  'lib/scripts',

  // ACF
  'fields/acf',

  // Post Types

  // Taxonomies

  // Components
  // 'components/gallery',
  // 'components/google_maps',
  'components/nav',
  'components/svg_icon',
  'components/related_posts'
]);
