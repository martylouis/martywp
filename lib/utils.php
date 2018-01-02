<?php
/**
 * Set of Utilities used throughout this theme
 *
 * @package martywp
 */

namespace MartyWP\Lib;

if (!defined('ABSPATH')) exit;

class Utils {

  function __construct() {
    // Do something...
  }

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
   * Page titles
   */
  public static function title() {
    if (is_home()) {
      if (get_option('page_for_posts', true)) {
        return get_the_title(get_option('page_for_posts', true));
      } else {
        return __('Latest Posts', 'martywp');
      }
    } elseif (is_archive()) {
      return get_the_archive_title();
    } elseif (is_search()) {
      return sprintf(__('Search Results for %s', 'martywp'), get_search_query());
    } elseif (is_404()) {
      return __('Not Found', 'martywp');
    } else {
      return get_the_title();
    }
  }


  /**
   *  Get assets based on MARTYWP_ENV
   */
  public static function asset_path($name, $type) {
    if (MARTYWP_ENV === 'development') {
      $asset_dir = get_template_directory_uri() . '/assets';
      $min = '';
    } else {
      $asset_dir = get_template_directory_uri() . '/assets/dist';
      $min = '.min';
    }
    return $path = sprintf('%1$s/%4$s/%2$s%3$s.%4$s', $asset_dir, $name, $min, $type);
  }


  /**
   * Post and Page thumbnails
   */
  function _base_thumb($post, $size, $link = false ) {
    if ( has_post_thumbnail() && $link = false ) :
      the_post_thumbnail($size);
    elseif ( has_post_thumbnail() ) :
      printf('<a itemprop="url" href="%1$s">%2$s</a>', esc_url(get_the_permalink($post)), get_the_post_thumbnail($post, $size));
    endif;
  }


  /**
   * Show related posts based on tags added to post
   *
   * To be used on single.php templates
   */
  public static function related_posts($post, $posts_per_page = 3) {
    $this_post = $post;
    global $post;
    $tags = wp_get_post_tags($post->ID);

    if ($tags) :
      $tag_ids = [];

      foreach ($tags as $tag) :
        $tag_ids[] = $tag->term_id;
      endforeach;

      $args = [
        'tag__in' => $tag_ids,
        'post__not_in' => [$post->ID],
        'posts_per_page' => $posts_per_page
      ];

      $related_posts = new WP_Query($args);

      if ($related_posts->have_posts()) :
        while ( $related_posts->have_posts() ) : $related_posts->the_post();
          get_template_part('components/post/list', 'related');
        endwhile;
        $post = $this_post;
        wp_reset_postdata();

      endif;

    endif;

  }


}
