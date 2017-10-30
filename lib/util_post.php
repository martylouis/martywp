<?php

/**
 *
 */
class PostUtils {

  function __construct() {
    // code...
  }

  static function related($post, $posts_per_page = 3) {
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
