<?php

/**
 * Set Working Environment
 */
if (!defined('WP_ENV')) {
  define('WP_ENV', 'production');
}


/**
 * _base Theme setup
 */
function _base_setup() {
  // Make theme available for translation
  // Community translations can be found at https://github.com/roots/roots-translations
  load_theme_textdomain('_base', get_template_directory() . '/lang');

  // Add default posts and comments RSS feed links to head.
  add_theme_support( 'automatic-feed-links' );

  // Enable plugins to manage the document title
  // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
  add_theme_support('title-tag');

  // Register wp_nav_menu() menus
  // http://codex.wordpress.org/Function_Reference/register_nav_menus
  register_nav_menus(array(
    'header_menu' => __('Header Menu', '_base'),
    'footer_menu' => __('Footer Menu', '_base')
  ));

  // Add post thumbnails
  // http://codex.wordpress.org/Post_Thumbnails
  // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
  // http://codex.wordpress.org/Function_Reference/add_image_size
  add_theme_support('post-thumbnails');

  // Add post formats
  // http://codex.wordpress.org/Post_Formats
  // add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio'));

  //    Switch default core markup for search form, comment form, and comments to output valid HTML5.
  add_theme_support( 'html5', array('comment-form', 'comment-list', 'gallery', 'caption', ));

  // Enable to load jQuery from the Google CDN
  add_theme_support('jquery-cdn');

  // Tell the TinyMCE editor to use a custom stylesheet
  add_editor_style('/assets/css/editor-style.css');

  // add_theme_support('soil-clean-up');         // Enable clean up from Soil
  // add_theme_support('soil-relative-urls');    // Enable relative URLs from Soil
  // add_theme_support('soil-nice-search');      // Enable /?s= to /search/ redirect from Soil
  // add_theme_support('bootstrap-gallery');     // Enable Bootstrap's thumbnails component on [gallery]
}
add_action('after_setup_theme', '_base_setup');



/**
 * Disable WP Emojis
 * @link http://wordpress.stackexchange.com/questions/185577/disable-emojicons-introduced-with-wp-4-2)
 */

function disable_emojicons_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}

function disable_wp_emojicons() {

  // all actions related to emojis
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

  // filter to remove TinyMCE emojis
  add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
add_action( 'init', 'disable_wp_emojicons' );
