<?php
  while (have_posts()) : the_post();
    get_template_part('parts/page', 'thumb');
    get_template_part('parts/page', 'header');
?>
    <div class="content"><?php the_content(); ?></div>
<?php endwhile; ?>
