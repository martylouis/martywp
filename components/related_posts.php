<?php

// Display Related Posts
function display_related_posts($post) {
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
      'posts_per_page' => 3
    ];

    $related_posts = new WP_Query($args);

    if ($related_posts->have_posts()) :
?>
<h3 class="section-heading">Related Posts</h3>
<div class="related-post-list post-list">
<?php while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
  <div class="post-list-article" itemscope itemtype="http://schema.org/BlogPosting">
    <?php $post_thumbnail = get_the_post_thumbnail($post->ID, [350,200], ['itemprop' => 'image']); ?>
    <?php if (has_post_thumbnail()) printf(__('<div class="post-thumb"><a itemprop="url" href="%s" alt="%s">%s</a></div>'), get_the_permalink(), get_the_title(), $post_thumbnail); ?>
    <h4 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
  </div>
<?php
  endwhile;
  $post = $this_post;
  wp_reset_postdata();
?>
</div>
<?php
  endif;
endif;
}
