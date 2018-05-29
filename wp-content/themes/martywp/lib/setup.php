<?php

namespace martywp;

class setup {

  function __construct() {

    add_action('after_setup_theme', [$this, 'theme_defaults']);
    add_action('widgets_init', [$this, 'widgets']);
    add_action( 'init', [$this, 'disable_wp_emojicons'] );

    add_filter('body_class', [$this, 'body_class']);
    add_filter('get_search_form', [$this, 'search_form']);
    add_filter('excerpt_more', [$this, 'excerpt_more']);
    add_filter('excerpt_length', [$this, 'excerpt_length'], 999);
    add_filter('get_the_archive_title', [$this, 'archive_title']);
    add_filter('image_size_names_choose', [$this, 'custom_img_size_names']);
    add_filter('the_content', [$this, 'filter_ptags_on_images']);
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
      'header_nav' => __('Header Nav', 'martywp'),
      // 'nav_secondary' => __('Secondary nav', 'martywp')
      // 'menu_blog' => __('Blog Menu', 'martywp'),
    ));

    // Add post thumbnails
    // http://codex.wordpress.org/Post_Thumbnails
    // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
    // http://codex.wordpress.org/Function_Reference/add_image_size
    add_theme_support('post-thumbnails');

      // Update Media sizes
      update_option('thumbnail_size_w', '128');
      update_option('thumbnail_size_h', '128');
      update_option('medium_size_w', '768');
      update_option('medium_size_h', '768');


      // Cropped Image Sizes
      add_image_size('crop_square_ti', 256, 256, true);
      // add_image_size('crop_square_xs', 384, 384, true);
      // add_image_size('crop_square_sm', 512, 512, true);
      // add_image_size('crop_square_md', 768, 768, true);
      // add_image_size('crop_square_lg', 1024, 1024, true);
      // add_image_size('crop_square_xl', 1920, 1920, true);

      // Classic (3:2)
      add_image_size('crop_classic_xs', 384, 256, true);
      add_image_size('crop_classic_sm', 512, 341, true);
      add_image_size('crop_classic_md', 768, 512, true);
      add_image_size('crop_classic_lg', 1024, 683, true);
      add_image_size('crop_classic_xl', 1920, 1280, true);

      // Standard(4:3)
      // add_image_size('crop_standard_xs', 384, 288, true);
      // add_image_size('crop_standard_sm', 512, 384, true);
      // add_image_size('crop_standard_md', 768, 576, true);
      // add_image_size('crop_standard_lg', 1024, 683, true);
      // add_image_size('crop_standard_xl', 1920, 1440, true);

      // HD(16:9)
      // add_image_size('crop_hd_xs', 384, 216, true);
      // add_image_size('crop_hd_sm', 512, 288, true);
      // add_image_size('crop_hd_md', 768, 432, true);
      // add_image_size('crop_hd_lg', 1024, 476, true);
      // add_image_size('crop_hd_xl', 1920, 1080, true);

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
   * Custom Image Size Names
   *
   * Add custom image size names for use within the WP Admin
   */
  function custom_img_size_names($sizes) {
    $names = [
      'crop_square_ti' => __('Square Tiny'),
      'crop_classic_xs' => __('(3:2) X-Small'),
      'crop_classic_sm' => __('(3:2) Small'),
      'crop_classic_md' => __('(3:2) Medium'),
      'crop_classic_lg' => __('(3:2) Large'),
      'crop_classic_xl' => __('(3:2) X-Large'),
    ];

    return array_merge($sizes, $names);
  }


  /**
   * Setup Widgets
   */
  function widgets() {
    register_sidebar(array(
      'name'          => __('Page Sidebar', 'martywp'),
      'id'            => 'page-sidebar',
      'before_widget' => '<section class="widget gr30__widget %1$s %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<div class="widget__header"><h3 class="widget__title">',
      'after_title'   => '</h3></div>',
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
    add_filter( 'tiny_mce_plugins', [$this, 'disable_emojicons_tinymce'] );
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

    if (has_post_thumbnail()) :
      $classes = array_merge($classes, ['page--has-thumb']);
    endif;

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
    return sprintf(__(' &hellip; <p class="entry-read-more"><a class="button outline sm" href="%s">Read More &rarr;</a></p>'), get_permalink());
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
      $title = sprintf(__('<span class="author">Articles by: %s</span>', 'martywp'), get_the_author());
    } elseif (is_post_type_archive()) {
      $title = post_type_archive_title('', false);
    } elseif (is_tax()) {
      $title = single_term_title('', false);
    }

    return $title;
  }

  function filter_ptags_on_images($content){
    return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
  }


}

new Setup;
