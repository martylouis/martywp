<?php
/**
 * Add `async` and `defer` to Google API Scripts
 */
function add_defer_attribute($tag, $handle) {
    if ( 'google_maps' !== $handle )
        return $tag;
    return str_replace( ' src', ' defer src', $tag );
}

// add_filter('script_loader_tag', 'add_defer_attribute', 10, 2);


/**
 * Enqueue Google Maps API script
 * Docs: https://developers.google.com/maps/documentation/javascript/tutorial?authuser=1#Loading_the_Maps_API
 * - API key needs to be defined in wp-admin/admin.php?page=acf-options-external-services
 */

function google_map_scripts() {
  if ( function_exists('get_field') && get_field('google_maps_api_key', 'options')) :
    $gmaps_api_key = get_field('google_maps_api_key', 'options');
  else :
    $gmaps_api_key = 'NO-KEY-SET';
  endif;

  $gmaps_api_url = 'https://maps.googleapis.com/maps/api/js?key=' . $gmaps_api_key;

  // Add templates for use with google maps
  $page_templates = [
    // 'templates/contact-page.php'
  ];

  if (is_page_template( $page_templates )) :
    wp_enqueue_script( 'google_maps', $gmaps_api_url, array(), null, false);
  endif;
}

// add_action('wp_enqueue_scripts', 'google_map_scripts');
