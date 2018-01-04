<?php
/**
 * Set of Utilities used throughout this theme
 *
 * @package martywp
 */

namespace MartyWP\Lib;

if (!defined('ABSPATH')) exit;

class Utils {

  /**
   * Debug code in Javascript console
   */

  public static function debug($data, $type = 'log') {
    $debug = '';
    if( is_array($data) || is_object($data) ) :
      $debug = sprintf('<script>console.%1$s(%2$s)</script>', $type, json_encode($data));
    else :
      $debug = sprintf('<script>console.%1$s("%2$s")</script>', $type, $data);
    endif;

    echo $debug;
  }

  /**
   * Display images in assets folder
   */
  public static function get_img($img) {
    $wp_dev = (MARTYWP_ENV === 'development' ? true : false);
    $template_dir = get_template_directory_uri();
    $img_dir = $wp_dev ? '/assets/img/' : '/assets/dist/img/';
    $img_path = sprintf('%1$s%2$s%3$s', $template_dir, $img_dir, $img);

    return $img_path;
  }

  public static function the_img($img) {
    echo self::get_img($img);
  }

  /**
   * Display svg icons
   */
  public static function get_svg($icon_name) {
    return sprintf('<i class="icon icon-%1$s"><svg class="svg"><use xlink:href="#svg-%1$s"></svg></i>', $icon_name);
  }

  public static function the_svg($icon_name) {
    echo self::get_svg($icon_name);
  }


  /*
   * Sanitize Phone numbers
   */
  public static function sanitize_phone($phone) {
    $san_phone = preg_replace("/[^0-9]/","",esc_attr( $phone ));
    return $san_phone;
  }

  /**
   *  Get assets based on MARTYWP_ENV
   */
  public static function get_assets_path($name, $type) {
    if (MARTYWP_ENV === 'development') {
      $asset_dir = get_template_directory_uri() . '/assets';
      $min = '';
    } else {
      $asset_dir = get_template_directory_uri() . '/assets/dist';
      $min = '.min';
    }
    return $path = sprintf('%1$s/%4$s/%2$s%3$s.%4$s', $asset_dir, $name, $min, $type);
  }
}
