<?php

namespace martywp\lib;
use martywp\utils;

/**
* Load our theme Scripts!
*
* @package martywp
*/

if (!defined('ABSPATH')) exit;

class scripts {

  function __construct() {

    $this->settings = [
      'jquery_version' => '3.2.1',
    ];

    add_action('wp_enqueue_scripts', [$this, 'load_scripts'], 100);
    add_action('wp_head', [$this, 'jquery_fallback']);

  }

  function pkg_version() {
    if (MARTYWP_ENV === 'development') :
      $pkg_file = file_get_contents(get_template_directory() . '/package.json');
      $pkg_data = json_decode($pkg_file, true);
      return $pkg_data['version'];
    else :
      return NULL;
    endif;
  }

  public function load_scripts() {

    wp_enqueue_style('base_css', utils::assets_path('styles', 'css'), null, $this->pkg_version(), null);

    if (!is_admin() && current_theme_supports('jquery-cdn')) {
      wp_deregister_script('jquery');
      wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/'. $this->settings['jquery_version'] . '/jquery.min.js', array(), null, false);
      add_filter('script_loader_src', [$this, 'jquery_fallback'], 10, 2);
    }
    wp_enqueue_script('jquery');

    if (is_single() && comments_open() && get_option('thread_comments')) {
      wp_enqueue_script('comment-reply');
    }

    wp_enqueue_script('base_js', utils::assets_path('scripts', 'js'), array(), $this->pkg_version(), true);
  }

  /**
   *  jQuery Local Fallback
   *  @link http://wordpress.stackexchange.com/a/12450
   */
  public function jquery_fallback($src, $handle = null) {
    static $add_jquery_fallback = false;

    if ($add_jquery_fallback) {
      echo '<script>window.jQuery || document.write(\'<script src="' . get_template_directory_uri() . '/dist/js/vendor/jquery.min.js"><\/script>\')</script>' . "\n";
      $add_jquery_fallback = false;
    }

    if ($handle === 'jquery') {
      $add_jquery_fallback = true;
    }

    return $src;
  }


}

new Scripts;
