<?php

if ( WP_ENV === 'development') :

  add_filter('acf/settings/show_admin', '__return_true');

  function _base_acf_json_save_point( $path ) {
    $path = get_stylesheet_directory() . '/fields/json';
    return $path;
  }

  add_filter('acf/settings/save_json', '_base_acf_json_save_point');

else :

  // Hide ACF admin on production
  add_filter('acf/settings/show_admin', '__return_false');

  function _base_acf_json_load_point( $paths ) {
    unset($paths[0]); // remove original path (optional)
    $paths[] = get_stylesheet_directory() . '/fields/json';
    return $paths;
  }

  add_filter('acf/settings/load_json', '_base_acf_json_load_point');

endif;


// Ninja Form Integration
function acf_load_ninja_forms($field) {
  // Reset Choices
  $field['choices'] = [];

  // Get Ninja Form Ids and Titles
  $forms = Ninja_Forms()->form()->get_forms();

  foreach ($forms as $form) {
    $label = $form->get_setting('title');
    $value = $form->get_id();

    $field['choices'][$value] = $label;
  }

  return $field;
}
add_filter('acf/load_field/name=select_form', 'acf_load_ninja_forms');
