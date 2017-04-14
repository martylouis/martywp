<?php

/**
 * Helper function to pretty up the errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */

$_base_error = function($message, $subtitle = '', $title = '') {
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
array_map(function($file) use ($_base_error) {
  $file = "{$file}.php";
  if (!locate_template($file, true, true)) {
    $_base_error(sprintf(__('Error locating <code>%s</code>', '_base'), $file), 'File not found');
  }
}, [
  'lib/helpers',
  'lib/activation',
  'lib/setup',
  'lib/config',
  'lib/wrapper',
  'lib/sidebar',
  'lib/nav',
  'lib/scripts',

  // ACF
  'fields/acf',

  // Post Types
  // 'post-types/',

  // Components
  // 'components/gallery',
  'components/google_maps'
]);
