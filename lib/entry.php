<?php

namespace MartyWP\Lib;

use WP_Query;

if (!defined('ABSPATH')) exit;

/**
 * Common entry utilities for display within loop
 */

class Entry {

  /**
   * Entry titles
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
   * Thumb
   */
  function thumb($post, $size, $link = false ) {
    if ( has_post_thumbnail() && $link = false ) :
      the_post_thumbnail($size);
    elseif ( has_post_thumbnail() ) :
      sprintf('<a itemprop="url" href="%1$s">%2$s</a>', esc_url(get_the_permalink($post)), get_the_post_thumbnail($post, $size));
    endif;
  }


  /**
   * Related Posts
   *
   * Display Related Posts based on recent posts with the same terms (tags)
   *
  */

  public static function related($post, $posts_per_page = 2) {
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

new Entry;
