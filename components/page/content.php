<?php  while (have_posts()) : the_post(); ?>
  <div class="container">
    <main class="site-main">
      <article <?php post_class('main-content'); ?>>
        <?php get_template_part('components/post/header'); ?>
        <?php get_template_part('components/post/thumb'); ?>
        <div class="entry-content"><?php the_content(); ?></div>
      </article>
      <div class="main-sidebar">
        <?php get_template_part('components/sidebar/primary'); ?>
      </div>
    </main>
  </div>
<?php endwhile; ?>
