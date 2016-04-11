<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('parts/page', 'thumb'); ?>
  <?php get_template_part('parts/page', 'header'); ?>
  <div class="page-content">
    <?php the_content(); ?>
  </div>
  <div class="page-footer">
    <?php // wp_link_pages(array('before' => '<nav class="pagination">', 'after' => '</nav>')); ?>
  </div>
<?php endwhile; ?>
