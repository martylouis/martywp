<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package martywp
 */

get_template_part('components/header/primary'); ?>

<div class="container">
  <div class="grid">
    <div class="content">
      <?php
        while (have_posts()) : the_post();
          get_template_part('components/post/content', get_post_format());
        endwhile;
       ?>
    </div>
    <?php get_template_part('components/sidebar/primary'); ?>
  </div>
</div>

<?php get_template_part('components/footer/primary');
