<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('parts/page', 'header'); ?>
  <?php get_template_part('parts/page', 'content'); ?>
<?php endwhile; ?>
