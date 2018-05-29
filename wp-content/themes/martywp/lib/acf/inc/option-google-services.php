<?php

namespace MartyWP\Lib\ACF\Option;

use MartyWP\Lib\Utils;

if (!defined('ABSPATH')) exit;

class GoogleServices {

  public function __construct() {

    add_action('wp_enqueue_scripts', [$this, 'google_analytics_script']);
    add_action('wp_head', [$this, 'google_analytics_code'], 20);

    // Load Google Maps API for ACF Plugin
    if (get_field('google_maps_api_key', 'option')) :
      add_action('wp_enqueue_scripts', [$this, 'google_maps_scripts']);
      add_filter('acf/fields/google_map/api', [$this, 'google_maps_acf_api_key']);
    endif;

    add_filter('script_loader_tag', [$this, 'async_scripts'], 10, 3);

  }

  /**
   * Add `async` to Google API Scripts
   *
   */
  public static function async_scripts($tag, $handle, $src) {
    $async_scripts = [
      'google_maps_api',
      'google_analytics'
    ];

    if (in_array($handle, $async_scripts)) :
      return sprintf('<script async src="%s"></script>' . "\n", $src);
    endif;

    return $tag;
  }

  public static function google_analytics_script() {
    $id = get_field('google_analytics_id', 'option');
    $api_url = 'https://www.googletagmanager.com/gtag/js?id=';

    if ($id) :
      wp_enqueue_script( 'google_analytics', $api_url . $id, array(), null, false);
    endif;
  }

  public static function google_analytics_code() {
    $id = get_field('google_analytics_id', 'option');

    $output = sprintf('<script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag(\'js\', new Date());
      gtag(\'config\', \'%s\');
    </script>', $id);

    if ( $id && !current_user_can('manage_options') && MARTYWP_ENV === 'production' ) :
      echo $output;
    elseif ( $id && (current_user_can('manage_options') || MARTYWP_ENV ==='development') ) :
      Utils::debug("Google Analytics ID: " .$id);
    else :
      Utils::debug("Google Analytics Not Set");
    endif;
  }


  public static function google_tag_manager() {
    $id = get_field('google_tag_manager_id', 'option');

    if ($id) :
      $output = sprintf('
      <!-- Google Tag Manager -->
      <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({\'gtm.start\':
          new Date().getTime(),event:\'gtm.js\'});var f=d.getElementsByTagName(s)[0],
          j=d.createElement(s),dl=l!=\'dataLayer\'?\'&l=\'+l:\'\';j.async=true;j.src=
          \'https://www.googletagmanager.com/gtm.js?id=\'+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,\'script\',\'dataLayer\',\'%s\');</script>
      <!-- End Google Tag Manager -->
      ', $id);
      else :
        $ouput = 'NO GOOGLE TAG MANAGER ID SETUP';
      endif;

      return $output;
  }


  public static function google_maps_scripts() {
    $api_key = get_field('google_maps_api_key', 'option');
    $url_prefix = 'https://maps.googleapis.com/maps/api/js?key=';

    if ($api_key) :
      $api_url = sprintf('%s%s', esc_url($url_prefix), $api_key);
    else :
       $api_url = sprintf('%s%s', esc_url($url_prefix), 'NO-API-KEY');
    endif;

    wp_enqueue_script( 'google_maps_api', $api_url, array(), null, false);

  }

  // Load key for ACF plugin Google Maps Field
  public static function google_maps_acf_api_key($api) {
    $api_key = get_field('google_maps_api_key', 'option');
    $api['key'] = $api_key ?: '';
  	return $api;
  }

}

new GoogleServices;
