<?php
/**
 * Advanced Custom Fields Pro Settings
 *
 * @link http://www.advancedcustomfields.com/resources/including-acf-in-a-plugin-theme/
 */

// Set ACF env
if ( WP_ENV === 'development') :
  add_filter('acf/settings/show_admin', '__return_true');

  // Save JSON custom path
  add_filter('acf/settings/save_json', '_base_acf_json_save_point');
  function _base_acf_json_save_point( $path ) {
    // update path
    $path = get_stylesheet_directory() . '/lib/acf/json';

    // return
    return $path;
  }

else :

  // Hide ACF admin on production
  add_filter('acf/settings/show_admin', '__return_false');

  // Load JSON custom path
  add_filter('acf/settings/load_json', '_base_acf_json_load_point');
  function _base_acf_json_load_point( $paths ) {
      // remove original path (optional)
      unset($paths[0]);
      $paths[] = get_stylesheet_directory() . '/lib/acf/json';
      return $paths;
  }

endif;
