<?php

if ( WP_ENV === 'development') :

  add_filter('acf/settings/show_admin', '__return_true');

  function _base_acf_json_save_point( $path ) {
    $path = get_stylesheet_directory() . '/fields/acf/json';
    return $path;
  }

  add_filter('acf/settings/save_json', '_base_acf_json_save_point');

else :

  // Hide ACF admin on production
  add_filter('acf/settings/show_admin', '__return_false');

  function _base_acf_json_load_point( $paths ) {
    unset($paths[0]); // remove original path (optional)
    $paths[] = get_stylesheet_directory() . '/fields/acf/json';
    return $paths;
  }

  add_filter('acf/settings/load_json', '_base_acf_json_load_point');

endif;
