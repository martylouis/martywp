<?php

namespace MartyWP\Lib\Setup;

use MartyWP\Lib\Utils;


class Setup {

  function __construct() {

    add_action('after_setup_theme', [$this, 'theme_defaults']);
    add_action('widgets_init', [$this, 'widgets']);
    add_action( 'init', [$this, 'disable_wp_emojicons'] );

    add_filter('body_class', [$this, 'body_class']);
    add_filter('get_search_form', [$this, 'search_form']);
    add_filter('excerpt_more', [$this, 'excerpt_more']);
    add_filter('excerpt_length', [$this, 'excerpt_length'], 999);
    add_filter('get_the_archive_title', [$this, 'archive_title']);
  }

  function theme_defaults() {

    // Make theme available for translation
    // Community translations can be found at https://github.com/roots/roots-translations
    load_theme_textdomain('martywp', get_template_directory() . '/lang');

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    // Enable plugins to manage the document title
    // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
    add_theme_support('title-tag');

    // Register wp_nav_menu() menus
    // http://codex.wordpress.org/Function_Reference/register_nav_menus
    register_nav_menus(array(
      'menu_primary' => __('Primary Menu', 'martywp'),
      // 'menu_blog' => __('Blog Menu', 'martywp'),
      // 'menu_footer' => __('Footer Menu', 'martywp')
    ));

    // Add post thumbnails
    // http://codex.wordpress.org/Post_Thumbnails
    // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
    // http://codex.wordpress.org/Function_Reference/add_image_size
    add_theme_support('post-thumbnails');
    add_image_size('featured_img', 1200, 1200, false);
    add_image_size('featured_img_thumb', 600, 600, false);

    // Add post formats
    // http://codex.wordpress.org/Post_Formats
    // add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio'));

    //    Switch default core markup for search form, comment form, and comments to output valid HTML5.
    add_theme_support( 'html5', array('comment-form', 'comment-list', 'gallery', 'caption', ));

    // Enable to load jQuery from the Google CDN
    add_theme_support('jquery-cdn');

    // Tell the TinyMCE editor to use a custom stylesheet
    add_editor_style('/assets/dist/css/editor-style.min.css');
  }

  /**
   * Setup Widgets
   */
  function widgets() {
    register_sidebar(array(
      'name'          => __('Primary', 'martywp'),
      'id'            => 'sidebar-primary',
      'before_widget' => '<aside class="widget %1$s %2$s">',
      'after_widget'  => '</aside>',
      'before_title'  => '<h3 class="widget-heading">',
      'after_title'   => '</h3>',
    ));

    register_sidebar(array(
      'name'          => __('Secondary', 'martywp'),
      'id'            => 'sidebar-secondary',
      'before_widget' => '<aside class="widget %1$s %2$s">',
      'after_widget'  => '</aside>',
      'before_title'  => '<h3 class="widget-heading">',
      'after_title'   => '</h3>',
    ));
  }


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

  /**
   * Add page slug to body_class() classes if it doesn't exist
   */
  function body_class($classes) {
    // Add post/page slug
    if (is_single() || is_page() && !is_front_page()) {
      if (!in_array(basename(get_permalink()), $classes)) {
        $classes[] = basename(get_permalink());
      }
    }
    return $classes;
  }

  /**
  * Tell WordPress to use form/search.php from the parts directory
  */
  function search_form() {
    $form = '';
    locate_template('/components/form/search.php', true, false);
    return $form;
  }

  /**
  * Clean up the_excerpt()
  */
  function excerpt_more() {
    return sprintf(__(' &hellip; <p class="entry-read-more"><a class="button" href="%s">Read More &rarr;</a></p>'), get_permalink());
  }

  /**
  * Update the_excerpt() length
  */
  function excerpt_length($length) {
    return 40;
  }

  /**
  * Modify Archive/Category Titles
  */
  function archive_title($title) {
    if (is_category()) {
      $title = single_cat_title('', false);
    } elseif (is_tag()) {
      $title = single_tag_title('', false);
    } elseif (is_author()) {
      $title = sprintf(__('<span class="author">Posts by %s</span>', 'martywp'), get_the_author());
    } elseif (is_post_type_archive()) {
      $title = post_type_archive_title('', false);
    } elseif (is_tax()) {
      $title = single_term_title('', false);
    }

    return $title;
  }


}

new Setup;
