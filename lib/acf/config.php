<?php

namespace MartyWP\Lib\ACF;

if (!defined('ABSPATH')) exit;

class Config {

  function __construct() {

    add_action('init', [$this, 'check_acf'], 99);
    add_filter('acf/settings/load_json', [$this, 'acf_json_load']);

    if ( MARTYWP_ENV === 'development') :
      add_filter('acf/settings/show_admin', '__return_true');
      add_filter('acf/settings/save_json', [$this, 'acf_json_save']);
    else :
      // Hide ACF admin on production
      add_filter('acf/settings/show_admin', '__return_false');
    endif;

    add_action('wp_loaded', [$this, 'acf_options_page'], 99);
    add_action('acf/input/admin_enqueue_scripts', [$this, 'acf_admin_styles'], 99);

    add_filter('acf/load_field/name=select_form', [$this, 'acf_ninja_forms']);

  }

  /**
   * Check for ACF
   */
  public static function check_acf() {
    $acf = class_exists('acf') ? acf() : NULL;
    if ( !isset( $acf ) || version_compare($acf->settings['version'], '5.0', '<') ) :
      add_action( 'admin_notices', [$this, 'acf_error_msg'] );
      add_action( 'network_admin_notices', [$this, 'acf_error_msg'] );
      return 'You need to install ACF!';
    else :
      return 'Success!';
    endif;
  }

  public static function acf_error_msg() {
    $msg = 'Please install Advanced Custom Fields.';
    printf(__('<div class="update error"><p>%s</p></div>'), $msg);
  }


  // Save JSON fields
  public static function acf_json_save( $path ) {
    $path = get_stylesheet_directory() . '/lib/acf/json';
    return $path;
  }

  // Load JSON fields

  public static function acf_json_load( $paths ) {
    unset($paths[0]); // remove original path (optional)
    $paths[] = get_stylesheet_directory() . '/lib/acf/json';
    return $paths;
  }

  // Setup Options Page

  public static function acf_options_page() {
    if( function_exists('acf_add_options_page') ) {
      acf_add_options_page([
        'page_title'   => 'Site Options',
        'menu_title' => 'Site Options',
        'menu_slug'  => 'site_options',
        'capability' => 'edit_posts',
        'redirect'   => true
      ]);
      acf_add_options_sub_page([
        'page_title'   => 'Business Information',
        'menu_title' => 'Business Info',
        'parent_slug'  => 'site_options',
      ]);
      acf_add_options_sub_page([
        'page_title'   => 'Google Services',
        'menu_title' => 'Google Services',
        'parent_slug'  => 'site_options',
      ]);
      acf_add_options_sub_page([
        'page_title'   => 'Code Injection',
        'menu_title' => 'Code Injection',
        'parent_slug'  => 'site_options',
      ]);
    }
  }

  /**
   * Load Custom Stylesheet
   */
  public static function acf_admin_styles() {
    wp_register_style('martywp_acf_admin_styles', get_template_directory_uri() . '/lib/acf/admin_styles.css', false, NULL);
    wp_enqueue_style('martywp_acf_admin_styles');
  }

  /**
   * Make Ninja Forms compatiable with ACF
   */
  public static function acf_ninja_forms($field) {
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


}

new Config;
