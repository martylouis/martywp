<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class('post-article'); ?>>
    <?php get_template_part('parts/post', 'thumb'); ?>
    <?php get_template_part('parts/post', 'header'); ?>
    <div class="post-content">
      <?php the_content(); ?>
    </div>
    <footer class="post-footer">
      <?php wp_link_pages(array('before' => '<nav class="post-nav"><p>' . __('Pages:', '_base'), 'after' => '</p></nav>')); ?>
    </footer>
    <?php comments_template('/parts/post-comments.php'); ?>
  </article>
<?php endwhile; ?>
