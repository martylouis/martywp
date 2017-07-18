<?php
  // Get global post count from index
  global $post_count;

  $thumb_size = $post_count > 1 ? 'featured_img_thumb' : 'featured_img';
  $featured_post_class = $post_count > 1 ? '' : ' post-featured';
  $post_thumbnail = get_the_post_thumbnail($post->ID, $thumb_size, ['itemprop' => 'image']);

?>

<article <?php post_class('post-list-article' . $featured_post_class); ?> itemscope itemtype="http://schema.org/BlogPosting">
  <?php if (has_post_thumbnail()) printf(__('<div class="post-thumb"><a itemprop="url" href="%s" alt="%s">%s</a></div>'), get_the_permalink(), get_the_title(), $post_thumbnail); ?>
  <div class="post-list-content">
    <header class="post-list-header">
      <h2 class="post-title" itemprop="headline">
        <a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
      </h2>
      <?php get_template_part('parts/post/meta'); ?>
    </header>
    <?php if ($post_count == 1) : ?>
      <div class="post-list-excerpt">
        <?php the_excerpt(); ?>
      </div>
    <?php else : ?>
      <div class="post-read-more">
        <a href="<?php echo the_permalink(); ?>" class="button"><?php _e('Read More &rarr;', '_base'); ?></a>
      </div>
    <?php endif; ?>
  </div>
</article>
