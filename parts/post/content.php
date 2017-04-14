<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class('post-article'); ?>>
    <div class="post-thumb">
      <?php _base_thumb( $post->ID, 'medium'); ?>
    </div>
    <header class="post-header">
      <h1 class="post-title"><?php the_title(); ?></h1>
      <?php get_template_part('parts/post/meta'); ?>
    </header>
    <div class="post-content">
      <?php the_content(); ?>
    </div>
    <footer class="post-footer">
      <?php wp_link_pages(array('before' => '<nav class="post-nav"><p>' . __('Pages:', '_base'), 'after' => '</p></nav>')); ?>
    </footer>
    <?php // comments_template('/parts/post/comments.php'); ?>
  </article>
<?php endwhile; ?>
