<div class="post-thumb">
  <?php if ( has_post_thumbnail() && is_single() ) : ?>
    <?php the_post_thumbnail('medium'); ?>
  <?php elseif ( has_post_thumbnail() ) : ?>
    <a href="<?php the_permalink(); ?>">
      <?php the_post_thumbnail('thumbnail'); ?>
    </a>
  <?php endif; ?>
</div>
