<header class="post-header">
  <?php if ( is_single() ) : ?>
    <h1 class="post-title"><?php the_title(); ?></h1>
  <?php else: ?>
    <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
  <?php endif; ?>
  <?php get_template_part('parts/post', 'meta'); ?>
</header>
