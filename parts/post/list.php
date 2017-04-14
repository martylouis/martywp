<li class="post-list-item">
  <article <?php post_class('post-article'); ?>>
    <div class="post-thumb">
      <?php _base_thumb( $post->ID, 'thumbnail', true); ?>
    </div>
    <header class="post-list-header">
      <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    </header>
    <div class="post-list-excerpt">
      <?php the_excerpt(); ?>
    </div>
  </article>
</li>
