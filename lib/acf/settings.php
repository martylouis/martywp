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


/**
 * Included Fields
 */

$acf_fields = array(
  'lib/acf/fields/options.php',
  'lib/acf/fields/icons.php',
);

foreach ($acf_fields as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', '_base'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);



/**
 * Options pages
 */

if( function_exists('acf_add_options_page') ) {

 acf_add_options_page(array(
   'page_title' 	=> 'Options',
   'menu_title'	=> 'Options',
   'menu_slug' 	=> 'options',
   'capability'	=> 'edit_posts',
   'redirect'		=> true
 ));

 acf_add_options_sub_page(array(
   'page_title' 	=> 'Contact Information',
   'menu_title'	=> 'Contact Info',
   'parent_slug'	=> 'options',
 ));

 acf_add_options_sub_page(array(
   'page_title' 	=> 'External Services',
   'menu_title'	=> 'External Services',
   'parent_slug'	=> 'options',
 ));

 acf_add_options_sub_page(array(
   'page_title' 	=> 'Code Injection',
   'menu_title'	=> 'Code Injection',
   'parent_slug'	=> 'options',
 ));

 acf_add_options_sub_page(array(
   'page_title' 	=> 'Site Alerts',
   'menu_title'	=> 'Site Alerts',
   'parent_slug'	=> 'options',
 ));
}
