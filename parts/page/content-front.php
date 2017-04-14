<?php  while (have_posts()) : the_post(); ?>

  <header class="page-header">
    <h1 class="page-title"><?php echo _base_title(); ?></h1>
  </header>

  <div class="content"><?php the_content(); ?></div>

<?php endwhile; ?>
