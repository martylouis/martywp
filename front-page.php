<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('parts/page', 'header'); ?>
  <div class="content">
    <?php the_content(); ?>
  </div>
<?php endwhile; ?>
