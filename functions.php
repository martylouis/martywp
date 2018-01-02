<?php

// Setup working environment
if (!defined('MARTYWP_ENV')) :
  define('MARTYWP_ENV', 'production');
endif;


/**
 * MartyWP Required Files
 *
 * The map array determines the code library included in this theme.
 * Add or remove files as needed.
 *
 * @package martywp
 */


// Helper function to pretty up the errors
$error_msg = function($message, $subtitle = '', $title = '') {
  $title = $title ?: __('<span style="color:orangered">Error!</span>', 'martywp');
  $message = "<h1>{$title}</h1><h3>{$subtitle}</span></h3><p>$message</p>";
  wp_die($message, $title);
};

array_map(function($file) use ($error_msg) {
  $file = "./lib/{$file}.php";
  if (!locate_template($file, true, true)) {
    $error_msg(sprintf(__('Error locating <code>%s</code>', 'martywp'), $file), 'File not found');
  }
}, [
  'utils',
  'setup',
  'scripts',

  // Addons
  'acf/config',
  'jetpack',
  // 'woocommerce'
]);
